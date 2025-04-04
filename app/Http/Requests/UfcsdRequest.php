<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UfcsdRequest extends FormRequest
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
            'uf_sec' => 'nullable|array',
            'uf_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'uf_sec.sec_order' => 'nullable|integer',
            'uf_sec.lang' => 'nullable|in:1,2',
            'uf_sec.display' => 'required|boolean',
            'uf_sec.active' => 'required|boolean',
    
            'uf_title' => 'nullable|string|max:255',
            'uf_subtitle' => 'nullable|string',
            'uf_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
