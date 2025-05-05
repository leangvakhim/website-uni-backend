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
            'set_facultytitle' => 'nullable|string',
            'set_facultydep'   => 'nullable|string',
            'set_logo'         => 'nullable|integer|exists:tbimage,image_id',
            'set_amstu'        => 'nullable|integer',
            'set_enroll'       => 'nullable|integer',
            'set_baseurl'      => 'nullable|string',
            'set_email'        => 'nullable|string|max:100',
            'lang'      => 'nullable|integer',
        ];
    }
}
