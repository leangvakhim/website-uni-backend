<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UfcsdRequest extends FormRequest
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

            'future' => 'nullable|array',
            'futre.*.uf_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'futre.*.uf_title' => 'nullable|string|max:255',
            'futre.*.uf_subtitle' => 'nullable|string',
            'futre.*.uf_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
