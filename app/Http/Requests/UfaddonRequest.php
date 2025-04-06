<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UfaddonRequest extends FormRequest
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
            'ufa_title' => 'nullable|string|max:50',
            'ufa_subtitle' => 'nullable|string',
            'ufa_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'ufa_uf' => 'nullable|array',
            'ufa_uf.uf_title' => 'nullable|string|max:255',
            'ufa_uf.uf_subtitle' => 'nullable|string',
            'ufa_uf.uf_img' => 'nullable|integer|exists:tbimage,image_id',
            'ufa_uf.uf_sec' => 'nullable|integer|exists:tbsection,sec_id',
        ];
    }
}
