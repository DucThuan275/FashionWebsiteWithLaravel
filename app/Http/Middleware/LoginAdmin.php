<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Nếu người dùng có role là 'customer', thì đăng xuất
            if ($user->roles === 'customer') {
                Auth::logout(); // Đăng xuất người dùng
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập trang này!');
            }
        }
        // Check if the user is not authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập!');
        }

        $user = Auth::user();

        // Check if the authenticated user is not an admin
        if ($user->roles !== 'admin') {
            return redirect()->route('site.home')->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        return $next($request);
    }
}
