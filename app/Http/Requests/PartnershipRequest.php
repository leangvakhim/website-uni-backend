<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnershipRequest extends FormRequest
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
            'ps_title' => 'nullable|string',
            'ps_img' => 'nullable|integer|exists:tbimage,image_id',
            'ps_type' => 'required|in:1,2',
            'ps_order' => 'nullable|integer',
            'active' => 'required|boolean',
        ];
    }
}
