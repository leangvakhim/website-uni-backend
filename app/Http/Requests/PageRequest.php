<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'p_menu' => 'nullable|integer|exists:tbmenu,menu_id',
            'p_title' => 'nullable|string|max:50',
            'p_alias' => 'nullable|string',
            'p_busy' => 'required|boolean',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'p_menu' => 'nullable|array',
            'p_menu.title' => 'nullable|string|max:255',
            'p_menu.menu_order' => 'nullable|integer',
            'p_menu.menup_id' => 'nullable|integer|exists:tbmenu,menu_id',
            'p_menu.lang' => 'nullable|integer|in:1,2',
            'p_menu.display' => 'nullable|boolean',
            'p_menu.active' => 'nullable|boolean',
        ];
    }
}
