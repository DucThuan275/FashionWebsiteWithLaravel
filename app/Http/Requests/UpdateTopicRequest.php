<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize()
    {
        // Kiểm tra quyền truy cập
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'sort_order'  => 'nullable|integer',
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Tên là bắt buộc.',
            'slug.required'        => 'Slug là bắt buộc.',
            'slug.unique'          => 'Slug đã tồn tại.',
            'status.required'      => 'Trạng thái là bắt buộc.',
        ];
    }
}
