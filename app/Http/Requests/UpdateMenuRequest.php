<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:1000',
            'link' => 'required|string|max:1000',
            'type' => 'required|string|max:1000',
            'sort_order'  => 'required|integer|min:0',
            'parent_id' => 'nullable|integer',
            'position' => 'nullable|string|in:mainmenu,footermenu', // Giới hạn giá trị của position
            'table_id' => 'nullable|integer',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên menu là bắt buộc.',
            'link.required' => 'Link menu là bắt buộc.',
            'sort_order.required' => 'Thứ tự menu là bắt buộc.',
            'position.in' => 'Vị trí menu phải là "mainmenu" hoặc "footermenu".',
            'status.required' => 'Trạng thái menu là bắt buộc.',
            'status.boolean' => 'Trạng thái menu phải là 0 (Không kích hoạt) hoặc 1 (Kích hoạt).',
            // Các thông báo lỗi khác nếu cần...
        ];
    }
}
