<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntroRequest extends FormRequest
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

            'introduction' => 'nullable|array',
            'introduction.*.in_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'introduction.*.in_title' => 'nullable|string|max:255',
            'introduction.*.in_detail' => 'nullable|string',
            'introduction.*.in_img' => 'nullable|integer|exists:tbimage,image_id',
            'introduction.*.inadd_title' => 'nullable|string',
            'introduction.*.in_addsubtitle' => 'nullable|string',
        ];
    }
}
