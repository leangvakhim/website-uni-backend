<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'specialization' => 'nullable|array',
            'specialization.*.ras_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'specialization.*.ras_img1' => 'nullable|integer|exists:tbimage,image_id',
            'specialization.*.ras_img2' => 'nullable|integer|exists:tbimage,image_id',
            'specialization.*.ras_text' => 'nullable|integer|exists:tbtext,text_id',

        ];
    }
}
