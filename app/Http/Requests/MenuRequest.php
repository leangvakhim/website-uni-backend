<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'menu_order' => 'nullable|integer',
            'menup_id' => 'nullable|integer|exists:tbmenu,menu_id',
            'lang' => 'nullable|integer|in:1,2',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
