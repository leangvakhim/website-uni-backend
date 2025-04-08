<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubtseRequest extends FormRequest
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
            'stse_title' => 'nullable|string|max:255',
            'stse_detail' => 'nullable|string',
            'stse_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'stse_tse' => 'nullable|array',
            'stse_tse.tse_type' => 'nullable|in:1,2',
            'stse_tse.tse_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'stse_tse.tse_text' => 'nullable|integer|exists:tbtext,text_id'
        ];
    }
}
