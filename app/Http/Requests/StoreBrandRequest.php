<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:0,1',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu không được bỏ trống.',
            'slug.required' => 'Slug không được bỏ trống.',
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Chỉ chấp nhận các định dạng hình ảnh: jpeg, png, jpg, gif, svg.',
            'description.string' => 'Mô tả phải là một chuỗi văn bản.',
            'sort_order.required' => 'Sắp xếp thứ tự là bắt buộc.',
            'status.required' => 'Trạng thái không được bỏ trống.',
        ];
    }

    public function authorize()
    {
        // Kiểm tra quyền truy cập
        return true; // Chỉ cho phép người dùng có quyền truy cập
    }
}
