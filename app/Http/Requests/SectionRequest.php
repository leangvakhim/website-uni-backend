<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'sec_order' => 'nullable|integer',
            'lang' => 'required|integer|in:1,2',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'sec_page' => 'nullable|array',
            'sec_page.p_title' => 'nullable|string|max:50',
            'sec_page.p_menu' => 'nullable|integer|exists:tbmenu,menu_id',
            'sec_page.p_alias' => 'nullable|string',
            'sec_page.p_busy' => 'nullable|boolean',
            'sec_page.display' => 'nullable|boolean',
            'sec_page.active' => 'nullable|boolean'
        ];
    }
}
