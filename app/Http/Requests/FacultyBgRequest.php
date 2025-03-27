<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyBgRequest extends FormRequest
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
            'fbg_name' => 'nullable|string|max:255',
            'fbg_img' => 'nullable|integer|exists:tbimage,image_id',
            'fbg_order' => 'required|integer',
            'active' => 'required|boolean',
            'display' => 'required|boolean',
        ];
    }
}
