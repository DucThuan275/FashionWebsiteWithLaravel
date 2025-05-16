<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Xác định quyền truy cập cho yêu cầu này.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng (hoặc thay đổi theo quyền)
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
            'name'          => 'required|string|max:1000|unique:product,name',
            'content'       => 'required|string',                     // Nội dung chi tiết sản phẩm
            'description'   => 'required|string',                     // Mô tả ngắn (tùy chọn)
            'price_buy'     => 'required|numeric|min:1',              // Giá nhập, không âm
            'price_sale'    => 'required|numeric|min:1|lte:price_buy', // Giá bán, phải nhỏ hơn hoặc bằng giá nhập
            'qty'           => 'required|integer|min:1',              // Số lượng, không âm
            'thumbnail'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048', // Kiểm tra file ảnh hợp lệ
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
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists'   => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.required'    => 'Thương hiệu sản phẩm là bắt buộc.',
            'brand_id.exists'      => 'Thương hiệu sản phẩm không tồn tại.',
            'name.required'        => 'Tên sản phẩm là bắt buộc.',
            'name.max'             => 'Tên sản phẩm không được vượt quá 1000 ký tự.',
            'slug.required'        => 'Slug sản phẩm là bắt buộc.',
            'slug.unique'          => 'Slug này đã tồn tại.',
            'slug.max'             => 'Slug không được vượt quá 1000 ký tự.',
            'content.required'     => 'Nội dung chi tiết sản phẩm là bắt buộc.',
            'price_buy.required'   => 'Giá nhập sản phẩm là bắt buộc.',
            'price_buy.min'        => 'Giá nhập sản phẩm không được nhỏ hơn 0.',
            'price_sale.required'  => 'Giá bán sản phẩm là bắt buộc.',
            'price_sale.min'       => 'Giá bán sản phẩm không được nhỏ hơn 0.',
            'price_sale.lte'       => 'Giá bán phải nhỏ hơn hoặc bằng giá nhập.',
            'qty.required'         => 'Số lượng sản phẩm là bắt buộc.',
            'qty.min'              => 'Số lượng sản phẩm không được nhỏ hơn 0.',
            'thumbnail.required'   => 'Thumbnail là bắt buộc.',
            'thumbnail.string'     => 'Thumbnail phải là một đường dẫn hợp lệ.',
            'thumbnail.max'        => 'Thumbnail không được vượt quá 1000 ký tự.',
            'created_by.required'  => 'ID người tạo sản phẩm là bắt buộc.',
            'created_by.exists'    => 'Người tạo không tồn tại.',
            'status.required'      => 'Trạng thái sản phẩm là bắt buộc.',
            'status.in'            => 'Trạng thái không hợp lệ (chỉ chấp nhận 0 hoặc 1).',
        ];
    }
}
