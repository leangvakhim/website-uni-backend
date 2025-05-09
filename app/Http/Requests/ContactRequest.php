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
            'con_img' => 'nullable|integer|exists:tbimage,image_id',
            'con_addon' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'con_addon2' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'con_addon3' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'lang' => 'nullable|integer'
        ];
    }
}
