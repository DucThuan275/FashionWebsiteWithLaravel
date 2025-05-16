<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền gửi yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Bạn có thể kiểm tra quyền của người dùng ở đây nếu cần
    }

    /**
     * Xác thực các trường yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        $categoryId = $this->route('id'); // Lấy ID của danh mục cần cập nhật từ route

        return [
            'name'        => 'required|string|max:1000',
            'parent_id'   => 'nullable|in:0',
            'sort_order'  => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB tối đa, ảnh không bắt buộc
            'description' => 'nullable|string|max:5000',
            'status'      => 'required|integer|in:0,1', // Giả sử 0 là "Không kích hoạt", 1 là "Kích hoạt"
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique'   => 'Slug này đã tồn tại. Vui lòng chọn slug khác.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'sort_order.required' => 'Sắp xếp là bắt buộc.',
            'sort_order.integer' => 'Sắp xếp phải là một số nguyên.',
            'image.image'    => 'Vui lòng chọn một tệp hình ảnh hợp lệ.',
            'image.mimes'    => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max'      => 'Kích thước hình ảnh tối đa là 2MB.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in'       => 'Trạng thái không hợp lệ. Chỉ có thể là 0 (Không kích hoạt) hoặc 1 (Kích hoạt).',
        ];
    }

    /**
     * Xác định các thuộc tính được hiển thị trong báo cáo lỗi.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'slug' => 'Slug',
            'parent_id' => 'Danh mục cha',
            'sort_order' => 'Sắp xếp',
            'image' => 'Hình ảnh',
            'description' => 'Mô tả',
            'status' => 'Trạng thái',
        ];
    }
}
