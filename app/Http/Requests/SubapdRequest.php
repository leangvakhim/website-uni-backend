<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubapdRequest extends FormRequest
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

            'apd_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'apd_title' => 'nullable|string',

            'subapd' => 'nullable|array',
            'subapd.*.sapd_apd' => 'nullable|integer|exists:tbapd,apd_id',
            'subapd.*.sapd_title' => 'nullable|string|max:255',
            'subapd.*.sapd_img' => 'nullable|integer|exists:tbimage,image_id',
            'subapd.*.sapd_routepage' => 'nullable|string',
            'subapd.*.display' => 'nullable|integer',
            'subapd.*.active' => 'nullable|boolean',
            'subapd.*.sapd_order' => 'nullable|integer',
        ];
    }
}
