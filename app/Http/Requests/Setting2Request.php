<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Setting2Request extends FormRequest
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

            'about' => 'nullable|array',
            'about.*.set_facultytitle' => 'nullable|string|max:50',
            'about.*.set_facultydep'   => 'nullable|string|max:50',
            'about.*.set_logo'         => 'nullable|integer|exists:tbimage,image_id',
            'about.*.set_amstu'        => 'required|numeric',
            'about.*.set_enroll'       => 'required|numeric',
            'about.*.lang'             => 'nullable|integer|in:1,2'
        ];
    }
}
