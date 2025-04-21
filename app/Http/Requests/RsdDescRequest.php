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
            'rsdt_text' => 'required|integer|exists:tbrsd_title,rsdt_id',
            'rsdt_rsd.rsdt_title' => 'nullable|string|max:255',
            'rsdt_rsd.rsdt_order' => 'nullable|integer',
           
            'rsdd_rsd' => 'nullable|array',
            'rsdd_rsd.*.rsdd_rsdtitle' => 'nullable|string|max:255',
            'rsdd_rsd.*.rsdd_details' => 'nullable|string',
            
        ];
    }
}