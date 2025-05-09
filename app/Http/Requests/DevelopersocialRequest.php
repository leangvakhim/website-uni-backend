<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevelopersocialRequest extends FormRequest
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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'd_name'      => 'nullable|string|max:50',
            'd_position'  => 'nullable|string|max:50',
            'd_write'     => 'nullable|string',
            'd_img'       => 'nullable|integer|exists:tbimage,image_id',
            'lang'        => 'nullable|in:1,2',
            'd_order'     => 'nullable|integer',

            'developer_social' => 'nullable|array',
            'developer_social.*.ds_title' => 'nullable|string|max:255',
            'developer_social.*.ds_img' => 'nullable|integer|exists:tbimage,image_id',
            'developer_social.*.ds_developer' => 'nullable|integer|exists:tbdeveloper,d_id',
            'developer_social.*.ds_link' => 'nullable|string|max:255',
            'developer_social.*.ds_order' => 'nullable|integer',
            'developer_social.*.display' => 'nullable|integer',
            'developer_social.*.active' => 'nullable|integer',


        ];
    }
}
