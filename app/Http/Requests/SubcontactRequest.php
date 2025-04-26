<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcontactRequest extends FormRequest
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
            'scon_title' => 'nullable|string|max:50',
            'scon_detail' => 'nullable|string|max:255',
            'scon_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
