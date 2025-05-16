<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ThanhVienController extends Controller
{
    public function login()
    {
        return view('frontend.login');
    }
    public function dologin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:4',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $args = [
            ['status', '=', 1],
        ];

        // Check if the username is an email or a normal username
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $args[] = ['email', '=', $username];
        } else {
            $args[] = ['username', '=', $username];
        }
        $user = User::where($args)->first();

        if ($user) {
            // Check the password
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                if ($request->has('customer')) {
                    Auth::login($user, true);
                }
                return redirect()->route('site.home')->with('success', 'Đăng nhập thành công');
            } else {
                return redirect()->route('site.login')->with('error', 'Mật khẩu không đúng');
            }
        } else {
            return redirect()->route('site.login')->with('error', 'Tên đăng nhập hoặc email không tồn tại');
        }
    }
    public function register()
    {
        return view('frontend.register');
    }
    // Xử lý đăng ký người dùng
    public function doregister(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:user,username',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User();
        $user->password = bcrypt($request->password);
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->roles = 'customer';
        $user->created_by = 1;
        $user->created_at = now();
        $user->status = 1;

        // Handle thumbnail upload (same as before)
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = now()->format('YmdHis') . '.' . $extension;
            $file->move(public_path('images/user'), $filename);
            $user->thumbnail = $filename;
        }

        // Save the user
        $user->save();

        return redirect()->route('site.login')->with('success', 'Đăng ký tài khoản thành công!');
    }
    public function profile()
    {
        $user = Auth::user();
        return view('frontend.profile', compact('user'));
    }
    public function editprofile()
    {
        $user = Auth::user();
        return view('frontend.editprofile', compact('user'));
    }
    // Process the profile update
    public function doeditprofile(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id !== Auth::id()) {
            return redirect()->route('site.profile')->with('error', 'Bạn không có quyền chỉnh sửa thông tin này.');
        }

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;

        if ($request->hasFile('thumbnail')) {
            if ($user->thumbnail && File::exists(public_path('images/user/' . $user->thumbnail))) {
                File::delete(public_path('images/user/' . $user->thumbnail));
            }
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = now()->format('YmdHis') . '.' . $extension;
            $file->move(public_path('images/user'), $filename);
            $user->thumbnail = $filename;
        }
        $user->save();
        return redirect()->route('site.profile')->with('success', 'Thông tin của bạn đã được cập nhật thành công!');
    }
    function logout()
    {
        Auth::logout();
        return redirect()->route('site.login')->with('success', 'Đăng xuất tài khoản thành công!');
    }
    public function order()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->select('id', 'name', 'email', 'phone', 'address', 'created_at', 'status')
            ->with('orderdetails')
            ->paginate(5);

        return view('frontend.order', compact('user', 'orders'));
    }
    public function orderdetail($id)
    {
        $order = Order::select("id", "name", "email", "phone", "address", "status")
            ->with('orderdetails.product') // Lấy thêm thông tin sản phẩm
            ->findOrFail($id);

        return view('frontend.orderdetail', compact('order'));
    }
}
