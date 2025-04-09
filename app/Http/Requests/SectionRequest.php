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
            'p_title' => 'nullable|string|max:50',
            'p_alias' => 'nullable|string',
            'p_busy' => 'nullable|integer',
            'p_menu' => 'nullable|integer|exists:tbmenu,menu_id',
            'lang' => 'nullable|integer|in:1,2',

            // Validate multiple social records
            'sections' => 'nullable|array',
            'sections.*.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sections.*.display' => 'nullable|boolean',
            'sections.*.sec_type' => 'nullable|string|max:255',
            'sections.*.sec_order' => 'nullable|integer'
        ];
    }
}
