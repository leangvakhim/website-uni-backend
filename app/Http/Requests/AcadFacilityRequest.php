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
            'af_img' => 'nullable|integer|exists:tbimage,image_id',

            'af_text' => 'nullable|array',
            'af_text.title' => 'nullable|string|max:255',
            'af_text.desc' => 'nullable|string', 
            'af_text.text_type' => 'nullable|in:1,2',
            'af_text.tag' => 'nullable|string|max:255',
            'af_text.lang' => 'nullable|in:1,2',
            'af_text.display' => 'required_with:af_text|boolean',
            'af_text.active' => 'required_with:af_text|boolean',

            'af_sec' => 'nullable|array',
            'af_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'af_sec.sec_order' => 'nullable|integer',
            'af_sec.lang' => 'nullable|in:1,2',
            'af_sec.display' => 'required_with:af_sec|boolean',
            'af_sec.active' => 'required_with:af_sec|boolean',

        ];
    }
}
