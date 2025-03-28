<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
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
            'social_img' => 'nullable|integer|exists:tbimage,image_id',
            'social_link' => 'nullable|string|max:255',
            'social_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
