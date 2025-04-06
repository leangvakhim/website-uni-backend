<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RasRequest extends FormRequest
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
            'ras_sec' => 'nullable|array',
            'ras_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'ras_sec.sec_order' => 'nullable|integer',
            'ras_sec.lang' => 'nullable|in:1,2',
            'ras_sec.display' => 'required|boolean',
            'ras_sec.active' => 'required|boolean', 

            'ras_img1' => 'nullable|integer|exists:tbimage,image_id',
            'ras_img2' => 'nullable|integer|exists:tbimage,image_id',

            'ras_text' => 'nullable|array',
            'ras_text.title' => 'nullable|string|max:255',
            'ras_text.desc' => 'nullable|string',
            'ras_text.text_type' => 'nullable|integer|in:1,2',
            'ras_text.tag' => 'nullable|string|max:255',
            'ras_text.lang' => 'nullable|in:1,2',
        ];
    }
}
