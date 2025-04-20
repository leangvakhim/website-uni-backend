<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderSectionRequest extends FormRequest
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


            'headersection' => 'nullable|array',
            'headersection.*.hsec_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'headersection.*.hsec_title' => 'nullable|string',
            'headersection.*.hsec_subtitle' => 'nullable|string',
            'headersection.*.hsec_btntitle' => 'nullable|string',
            'headersection.*.hsec_routepage' => 'nullable|string',
            'headersection.*.hsec_amount' => 'nullable|integer',
        ];
    }
}
