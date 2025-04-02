<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdDescRequest extends FormRequest
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
            'rsdd_rsdtile' => 'nullable',

            // as int       FK
            'rsdd_rsdtile' => 'nullable|integer|exists:tbrsd_title,rsdt_id',

            // if passing as object
            'rsdd_rsdtile' => 'nullable|array',
            'rsdd_rsdtile.rsdt_title' => 'nullable|string|max:255',
            'rsdd_rsdtile.rsdt_order' => 'nullable|integer',
            'rsdd_rsdtile.display' => 'nullable|boolean',
            'rsdd_rsdtile.active' => 'nullable|boolean',

            'rsdd_details' => 'nullable|string',
            'active' => 'required|boolean',
        ];
    }
}
