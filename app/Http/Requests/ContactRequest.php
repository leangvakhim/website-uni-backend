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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'contact' => 'nullable|array',
            'contact.*.con_title' => 'nullable|string|max:255',
            'contact.*.con_subtitle' => 'nullable|string',
            'contact.*.con_img' => 'nullable|integer|exists:tbimage,image_id',
            'contact.*.con_addon' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'contact.*.con_addon2' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'contact.*.con_addon3' => 'nullable|integer|exists:tbsubcontact,scon_id',
            'contact.*.lang' => 'nullable|integer'
        ];
    }
}
