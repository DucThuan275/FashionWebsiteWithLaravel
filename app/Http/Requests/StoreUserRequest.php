<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Hoặc kiểm tra quyền người dùng nếu cần
    }

    /**
     * Xác thực dữ liệu gửi lên.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:user,username,' . ($this->route('user') ?: '0'),
            'password' => 'required|string|min:4|confirmed',
            'fullname' => 'required|string|max:25',
            'gender' => 'required|in:male,female',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|email|max:1000|unique:user,email,' . ($this->route('user') ?: '0'),
            'phone' => 'required|string|max:1000',
            'address' => 'required|string|max:1000',
            'roles' => 'required|in:admin,customer',
            'status' => 'required|integer|min:0', // Assuming status is an integer and cannot be negative
        ];
    }

    /**
     * Các thông báo lỗi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'password.required' => 'Password is required.',
            'fullname.required' => 'Fullname is required.',
            'gender.required' => 'Gender is required.',
            // Thêm các thông báo lỗi khác nếu cần
        ];
    }
}
