<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:user,username,' . ($this->route('user') ?: '0'),
            'password' => 'required|string|min:4|confirmed',
            'fullname' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
