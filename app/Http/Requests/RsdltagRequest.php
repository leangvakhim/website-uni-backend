<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdltagRequest extends FormRequest
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
            'rsdlt_rsdl' => 'nullable|array',

            'rsdlt_rsdl.rsdl_title' => 'nullable|string|max:255',
            'rsdlt_rsdl.rsdl_detail' => 'nullable|string',
            'rsdlt_rsdl.rsdl_fav' => 'nullable|boolean',
            'rsdlt_rsdl.rsdl_img' => 'nullable|integer|exists:tbimage,image_id',
            'rsdlt_rsdl.lang' => 'nullable|integer|in:1,2',
        
            'rsdlt_rsdl.rsdl_order' => 'required|integer',
            'rsdlt_rsdl.display' => 'required|boolean',
            'rsdlt_rsdl.active' => 'required|boolean',
        
            'rsdlt_title' => 'required|string|max:100',
            'rsdlt_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
