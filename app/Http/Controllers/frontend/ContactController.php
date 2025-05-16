<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    function contact()
    {
        if (!Auth::check()) {
            return redirect()->route('site.login')->with('warning', 'Bạn cần đăng nhập để truy cập trang liên hệ.');
        }
        return view('frontend.contact');
    }
    public function sendcontact(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Lưu dữ liệu liên hệ
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'created_by' => Auth::id(),
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi!');
    }
}
