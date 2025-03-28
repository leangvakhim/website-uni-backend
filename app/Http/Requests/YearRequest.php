<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
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
            'y_title' => 'nullable|string|max:50',
            'y_subtitle' => 'nullable|string|max:255',
            'y_detail' => 'nullable|string',
            'y_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
