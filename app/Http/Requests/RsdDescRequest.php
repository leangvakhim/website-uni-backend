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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',
           
            'research_desc' => 'nullable|array',
            'research_desc.*.rsdd_rsdtitle' => 'nullable|string|max:255',
            'research_desc.*.rsdd_details' => 'nullable|string',
            
        ];
    }
}