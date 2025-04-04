<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdTitleRequest extends FormRequest
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
            'rsdt_title' => 'nullable|string|max:255',
            'rsdt_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
