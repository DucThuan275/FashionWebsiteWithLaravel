<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'sort_order' => 'required|integer',
            'status' => 'required|integer|in:0,1', // Giả sử trạng thái có 2 giá trị: 0 (ẩn) và 1 (hiển thị)
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên thương hiệu không được bỏ trống.',
            'slug.required' => 'Slug không được bỏ trống.',
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
