<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    function login()
    {
        return view("backend.user.login");
    }
    function dologin(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required',
        ]);

        $data_login = [
            'email' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::attempt($data_login)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('error', 'Thông tin không chính xác');
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    function doforgotpassword()
    {
        return view('backend.user.forgotpassword');
    }

    function forgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string',
        ]);

        // Kiểm tra xem email và username có thuộc về cùng một tài khoản không
        $user = DB::table('user')
            ->where('email', $request->email)
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email hoặc tên đăng nhập không đúng.']);
        }

        // Nếu hợp lệ, chuyển hướng đến trang đặt lại mật khẩu với thông tin email & username
        return view('backend.user.resetpassword', [
            'email' => $request->email,
            'username' => $request->username,
        ]);
    }
    function updatepassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        // Kiểm tra user
        $user = DB::table('user')
            ->where('email', $request->email)
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email hoặc tên đăng nhập không đúng.']);
        }

        // Cập nhật mật khẩu mới
        DB::table('user')
            ->where('email', $request->email)
            ->where('username', $request->username)
            ->update(['password' => bcrypt($request->password)]);

        return redirect()->route('admin.login')->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
