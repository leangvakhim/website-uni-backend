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
            'rason_title' => 'nullable|string',
            'rason_amount' => 'nullable|string',
            'rason_subtitle' => 'nullable|string',

            'rason_ras' => 'nullable|array',
            'rason_ras.ras_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'rason_ras.ras_img1' => 'nullable|integer|exists:tbimage,image_id',
            'rason_ras.ras_img2' => 'nullable|integer|exists:tbimage,image_id',
            'rason_ras.ras_text' => 'nullable|integer|exists:tbtext,text_id',
        ];
    }
}
