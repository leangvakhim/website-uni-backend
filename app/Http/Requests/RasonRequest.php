<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RasonRequest extends FormRequest
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

            'ras_text' => 'nullable|integer|exists:tbtext,text_id',
            'ras_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'ras_img1' => 'nullable|integer|exists:tbimage,image_id',
            'ras_img2' => 'nullable|integer|exists:tbimage,image_id',

            'rasons' => 'nullable|array',
            'rasons.*.rason_ras' => 'nullable|integer|exists:tbras,ras_id',
            'rasons.*.rason_title' => 'nullable|string|max:255',
            'rasons.*.rason_amount' => 'nullable|string',
            'rasons.*.rason_subtitle' => 'nullable|string',
        ];
    }
}
