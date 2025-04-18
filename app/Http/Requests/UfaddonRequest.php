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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'uf_title' => 'nullable|string',
            'uf_subtitle' => 'nullable|string',
            'uf_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'uf_img' => 'nullable|integer|exists:tbimage,image_id',

            'ufaddon' => 'nullable|array',
            'ufaddon.*.ufa_uf' => 'nullable|integer|exists:tbufcsd,uf_id',
            'ufaddon.*.ufa_title' => 'nullable|string|max:255',
            'ufaddon.*.ufa_subtitle' => 'nullable|string',
            'ufaddon.*.display' => 'nullable|boolean',
            'ufaddon.*.active' => 'nullable|boolean',
            'ufaddon.*.ufa_order' => 'nullable|integer',
        ];
    }
}
