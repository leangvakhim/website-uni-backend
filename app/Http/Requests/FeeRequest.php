<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
            'fe_sec' => 'nullable|array',
            'fe_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'fe_sec.sec_order' => 'nullable|integer',
            'fe_sec.lang' => 'nullable|in:1,2',
            'fe_sec.display' => 'required|boolean',
            'fe_sec.active' => 'required|boolean',
    
            'fe_title' => 'nullable|string|max:255',
            'fe_desc' => 'nullable|string',
            'fe_img' => 'nullable|integer|exists:tbimage,image_id',
            'fe_price' => 'nullable|string|max:10',
        ];
    }
}
