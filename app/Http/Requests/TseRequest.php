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
            'tse_type' => 'nullable|in:1,2',

            'tse_sec' => 'nullable|array',
            'tse_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'tse_sec.sec_order' => 'nullable|integer',
            'tse_sec.lang' => 'nullable|in:1,2',
            'tse_sec.display' => 'required_with:tse_sec|boolean',
            'tse_sec.active' => 'required_with:tse_sec|boolean',

            'tse_text' => 'nullable|array',
            'tse_text.title' => 'nullable|string|max:255',
            'tse_text.desc' => 'nullable|string',
            'tse_text.text_type' => 'nullable|in:1,2',
            'tse_text.tag' => 'nullable|string|max:255',
            'tse_text.lang' => 'nullable|in:1,2',
            'tse_text.display' => 'required_with:tse_text|boolean',
            'tse_text.active' => 'required_with:tse_text|boolean',
        ];
    }
}
