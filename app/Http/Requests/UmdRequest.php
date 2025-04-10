<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmdRequest extends FormRequest
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


            'unlock' => 'nullable|array',
            'unlock.*.umd_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'unlock.*.umd_title' => 'nullable|string|max:100',
            'unlock.*.umd_detail' => 'nullable|string',
            'unlock.*.umd_routepage' => 'nullable|string|max:100',
            'unlock.*.umd_btntext' => 'nullable|string|max:20',
            'unlock.*.umd_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
