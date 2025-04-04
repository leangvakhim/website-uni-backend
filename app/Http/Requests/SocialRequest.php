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
            'social_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
            'social_link' => 'nullable|string|max:255',

            'social_faculty' => 'nullable|array',
            'social_faculty.f_name' => 'nullable|string|max:255',
            'social_faculty.f_position' => 'nullable|string|max:100',
            'social_faculty.f_portfolio' => 'nullable|string',
            'social_faculty.f_img' => 'nullable|integer|exists:tbimage,image_id',
            'social_faculty.f_order' => 'nullable|integer',
            'social_faculty.lang' => 'nullable|integer|in:1,2',
            'social_faculty.display' => 'nullable|boolean',
            'social_faculty.active' => 'nullable|boolean',
        ];
    }
}
