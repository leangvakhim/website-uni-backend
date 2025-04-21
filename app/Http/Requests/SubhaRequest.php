<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubhaRequest extends FormRequest
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

            'ha_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'ha_title' => 'nullable|string|max:255',
            'ha_img' => 'nullable|integer|exists:tbimage,image_id',
            'ha_tagtitle' => 'nullable|string|max:255',
            'ha_subtitletag' => 'nullable|string|max:255',
            'ha_date' => 'nullable|date',

            'subapply' => 'nullable|array',
            'subapply.*.sha_ha' => 'nullable|integer|exists:tbha,ha_id',
            'subapply.*.sha_title' => 'nullable|string',
            'subapply.*.display' => 'nullable|boolean',
            'subapply.*.active' => 'nullable|boolean',
            'subapply.*.sha_order' => 'nullable|integer',
        ];
    }
}
