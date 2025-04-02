<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdProjectRequest extends FormRequest
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
            'rsdp_rsdtile' => 'nullable',

            // as int FK
            'rsdp_rsdtile' => 'nullable|integer|exists:tbrsd_title,rsdt_id',

            // if passing as object
            'rsdp_rsdtile' => 'nullable|array',
            'rsdp_rsdtile.rsdt_title' => 'nullable|string|max:255',
            'rsdp_rsdtile.rsdt_order' => 'nullable|integer',
            'rsdp_rsdtile.display' => 'nullable|boolean',
            'rsdp_rsdtile.active' => 'nullable|boolean',

            'rsdp_detail' => 'nullable|string',
            'active' => 'required|boolean',
        ];
    }
}
