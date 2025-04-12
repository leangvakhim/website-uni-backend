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
            'rsdl_id' => 'required|integer|exists:tbrsdl,rsdl_id',
            'rsdl_title' => 'nullable|string|max:255',
            'rsdl_detail' => 'nullable|string',
            'rsdl_fav' => 'nullable|boolean',
            'rsdl_img' => 'nullable|integer|exists:tbimage,image_id',
            'lang' => 'nullable|integer',

            // Validate multiple social records
            'rsdlt_rsdl' => 'nullable|array',
            'rsdlt_rsdl.*.rsdlt_title' => 'nullable|string|max:255',
            'rsdlt_rsdl.*.rsdlt_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}