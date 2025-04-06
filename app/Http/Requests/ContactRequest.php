<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'con_title' => 'nullable|string|max:255',
            'con_subtitle' => 'nullable|string',

            'con_addon' => 'nullable|array',
            'con_addon.scon_title' => 'nullable|string|max:50',
            'con_addon.scon_detail' => 'nullable|string|max:255',
            'con_addon.scon_img' => 'nullable|integer|exists:tbimage,image_id',
            'con_addon.scon_order' => 'nullable|integer',
            'con_addon.display' => 'required|boolean',
            'con_addon.active' => 'required|boolean',
        ];
    }
}
