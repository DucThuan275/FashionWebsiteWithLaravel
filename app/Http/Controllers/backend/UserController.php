<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')
            ->select('id', 'username', 'fullname', 'gender', 'email', 'phone', 'address', 'roles', 'status')
            ->paginate(10);

        return view('backend.user.index', compact('users'));
    }
    public function create()
    {
        $users = User::orderBy('created_at', 'ASC')
            ->select("id")
            ->get();
        return view('backend.user.create', compact('users'));
    }
    public function store(StoreUserRequest $request)
    {
        $user = new User();

        // If the password is provided, hash it and save it
        $user->password = bcrypt($request->password);

        // Continue with saving other user data
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->roles = $request->roles;
        $user->created_by = 1;
        $user->status = $request->status;

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

        // Redirect to the user list or any other page
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }
    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        $users = User::orderBy('created_at', 'asc')
            ->select("id", "username", "status")
            ->get();
        return view('backend.user.edit', compact('user', 'users'));
    }
    public function update(UpdateUserRequest $request, $id)
    {
        // Tìm người dùng cần cập nhật
        $user = User::findOrFail($id);

        // Cập nhật username, fullname, gender, email, phone, address, roles và status
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->roles = $request->roles;
        $user->status = $request->status;
        $user->updated_by = 1; // Có thể thay thế bằng giá trị động nếu có hệ thống đăng nhập

        // Cập nhật password nếu có giá trị mới
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Xử lý ảnh thumbnail nếu có thay đổi
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($user->thumbnail && File::exists(public_path('images/user/' . $user->thumbnail))) {
                File::delete(public_path('images/user/' . $user->thumbnail));
            }

            // Lưu ảnh mới
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = now()->format('YmdHis') . '.' . $extension;

            // Di chuyển file vào thư mục public/images/user
            $file->move(public_path('images/user'), $filename);

            // Cập nhật trường thumbnail của người dùng
            $user->thumbnail = $filename;
        }

        // Lưu các thay đổi
        $user->save();

        // Chuyển hướng về danh sách người dùng hoặc trang chi tiết
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function delete(string $id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Xóa vào thùng rác thành công!');
        }
        return redirect()->route("user.index")->with('error', 'Failed to delete');
    }
    public function restore(string $id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($user != null) {
            $user->restore();
            return redirect()->route('admin.user.trash')->with('success', 'Khôi phục thành công!');
        }
        return redirect()->route("user.trash")->with('error', 'Failed to restore');
    }
    public function destroy(string $id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        if ($user != null) {
            if ($user->image && File::exists(public_path("images/user/" . $user->image))) {
                File::delete(public_path("images/user/" . $user->image));
            }
            $user->forceDelete();
            return redirect()->route('admin.user.trash')->with('success', 'Xóa  thành công!');
        }
        return redirect()->route("admin.user.trash")->with('error', 'Failed to delete');
    }

    public function trash()
    {
        // Thay vì get(), sử dụng paginate() để phân trang kết quả
        $users = User::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')->select('id', 'fullname', 'username', 'status', 'deleted_at')
            ->paginate(10);  // Phân trang, ví dụ 10 bản ghi mỗi trang

        // Trả về view với dữ liệu phân trang
        return view('backend.user.trash', compact('users'));
    }

    public function status(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->status = $user->status ? 0 : 1;
            $user->updated_by = 1;
            $user->updated_at = now();

            if ($user->save()) {
                return redirect()->route('user.index')->with('success', 'Trạng thái đã được cập nhật thành công!');
            }
        }

        return redirect()->route('user.index')->with('error', 'Không tìm thấy user để cập nhật trạng thái.');
    }
    public function show($id)
    {
        $user = User::select("id", "username", "fullname", "gender", "thumbnail", "email", "phone", "address", "roles", "status")
            ->findOrFail($id);

        return view('backend.user.show', compact('user'));
    }
}
