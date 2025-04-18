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
            'set_facultytitle' => 'nullable|string|max:50',
            'set_facultydep'   => 'nullable|string|max:50',
            'set_logo'         => 'nullable|integer|exists:tbimage,image_id',
            'set_amstu'        => 'required|numeric',
            'set_enroll'       => 'required|numeric',
            'lang'             => 'nullable|integer|in:1,2'
        ];
    }
}
