<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcadFacilityRequest extends FormRequest
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

            'facilities' => 'nullable|array',
            'facilities.*.af_text' => 'nullable|integer|exists:tbtext,text_id',
            'facilities.*.af_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'facilities.*.af_img' => 'nullable|integer|exists:tbimage,image_id',

        ];
    }
}
