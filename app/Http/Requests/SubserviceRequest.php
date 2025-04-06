<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubserviceRequest extends FormRequest
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
            'ss_title' => 'nullable|string|max:255',
            'ss_subtitle' => 'nullable|string',
            'ss_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'ss_img' => 'nullable|integer|exists:tbimage,image_id',

            'ss_ras' => 'nullable|array',
            'ss_ras.ras_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'ss_ras.ras_text' => 'nullable|integer|exists:tbtext,text_id',
            'ss_ras.ras_img1' => 'nullable|integer|exists:tbimage,image_id',
            'ss_ras.ras_img2' => 'nullable|integer|exists:tbimage,image_id',

            'ss_af' => 'nullable|array',
            'ss_af.af_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'ss_af.af_text' => 'nullable|integer|exists:tbtext,text_id',
            'ss_af.af_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
