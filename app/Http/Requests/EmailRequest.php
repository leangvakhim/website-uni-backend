<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'm_firstname' => 'nullable|string|max:255',
            'm_lastname' => 'nullable|string|max:255',
            'm_email' => 'nullable|email|max:100',
            'm_description' => 'nullable|string',
            'm_active' => 'boolean'
        ];
    }
}
