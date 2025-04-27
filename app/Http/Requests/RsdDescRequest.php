<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdDescRequest extends FormRequest
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
            'research_desc' => 'nullable|array',
            'research_desc.*.rsdd_title' => 'nullable|string|max:255',
            'research_desc.*.rsdd_details' => 'nullable|string',
            'research_desc.*.rsdd_rsdtile' => 'nullable|integer',

        ];
    }
}