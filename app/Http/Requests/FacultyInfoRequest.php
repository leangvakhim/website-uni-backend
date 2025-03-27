<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyInfoRequest extends FormRequest
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
            'finfo_title' => 'nullable|string|max:255',
            'finfo_detail' => 'nullable|string',
            'finfo_side' => 'required||integer',
            'finfo_order' => 'required|integer',
            'active' => 'required|boolean',
            'display' => 'required|boolean',
        ];
    }
}
