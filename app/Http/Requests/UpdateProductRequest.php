<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Xác định quyền truy cập cho yêu cầu này.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng (hoặc có thể thay đổi theo quyền người dùng)
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'   => 'required|integer|exists:category,id', // Kiểm tra danh mục tồn tại
            'brand_id'      => 'required|integer|exists:brand,id',    // Kiểm tra thương hiệu tồn tại
            'name'          => 'required|string|max:1000',
            'content'       => 'required|string',                     // Nội dung chi tiết sản phẩm
            'description'   => 'required|string',                     // Mô tả ngắn (tùy chọn)
            'price_buy'     => 'required|numeric|min:1',              // Giá nhập, không âm
            'price_sale'    => 'required|numeric|min:1|lte:price_buy', // Giá bán, phải nhỏ hơn hoặc bằng giá nhập
            'qty'           => 'required|integer|min:1',              // Số lượng, không âm
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif,avif,webp|max:2048',
            'status'        => 'required|integer|in:0,1',             // Trạng thái (0: Không kích hoạt, 1: Kích hoạt)
        ];
    }

    /**
     * Các thông báo lỗi tuỳ chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.exists'   => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.exists'      => 'Thương hiệu sản phẩm không tồn tại.',
            'name.required'        => 'Tên sản phẩm là bắt buộc.',
            'slug.required'        => 'Slug sản phẩm là bắt buộc.',
            'slug.unique'          => 'Slug này đã tồn tại.',
            'content.required'     => 'Nội dung chi tiết sản phẩm là bắt buộc.',
            'price_buy.required'   => 'Giá nhập sản phẩm là bắt buộc.',
            'price_sale.required'  => 'Giá bán sản phẩm là bắt buộc.',
            'qty.required'         => 'Số lượng sản phẩm là bắt buộc.',
            'thumbnail.url'        => 'Đường dẫn hình ảnh thumbnail không hợp lệ.',
            'updated_by.required'  => 'ID người cập nhật sản phẩm là bắt buộc.',
            'updated_by.exists'    => 'Người cập nhật không tồn tại.',
        ];
    }
}
