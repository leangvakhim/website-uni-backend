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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'af_text' => 'nullable|integer|exists:tbtext,text_id',
            'af_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'af_img' => 'nullable|integer|exists:tbimage,image_id',



            'subservice' => 'nullable|array',
            'subservice.*.ss_af' => 'nullable|integer|exists:tbacadfacility,af_id',
            'subservice.*.ss_ras' => 'nullable|integer|exists:tbras,ras_id',
            'subservice.*.ss_img' => 'nullable|integer|exists:tbimage,image_id',
            'subservice.*.ss_title' => 'nullable|string|max:255',
            'subservice.*.ss_subtitle' => 'nullable|string',
            'subservice.*.display' => 'nullable|boolean',
            'subservice.*.active' => 'nullable|boolean',
            'subservice.*.ss_order' => 'nullable|integer',
        ];
    }
}
