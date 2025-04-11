<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TseRequest extends FormRequest
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

            'type' => 'nullable|array',
            'type.*.tse_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'type.*.tse_type' => 'nullable|integer',
            'type.*.tse_text' => 'nullable|integer|exists:tbtext,text_id',
        ];
    }
}
