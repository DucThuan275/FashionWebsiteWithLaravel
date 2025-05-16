<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Có thể thêm điều kiện nếu cần kiểm tra quyền
    }

    /**
     * Xác định các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'topic_id'    => 'nullable|exists:topic,id', // Nếu có trường chủ đề
            'type'        => 'required|in:post,page',
            'content'     => 'required|string',
            'description' => 'nullable|string',
            'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Kiểm tra file ảnh
            'status'      => 'required|boolean',
        ];
    }

    /**
     * Các thông báo lỗi tùy chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'     => 'Tiêu đề là bắt buộc.',
            'slug.required'      => 'Slug là bắt buộc.',
            'slug.unique'        => 'Slug đã tồn tại.',
            'content.required'   => 'Nội dung bài viết là bắt buộc.',
            'thumbnail.required' => 'Hình ảnh là bắt buộc.',
            'thumbnail.image'    => 'Vui lòng chọn một hình ảnh hợp lệ.',
            'thumbnail.max'      => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'status.required'    => 'Trạng thái là bắt buộc.',
        ];
    }
}
