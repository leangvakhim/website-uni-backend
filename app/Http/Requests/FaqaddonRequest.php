<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqaddonRequest extends FormRequest
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
            'fa_question' => 'nullable|string',
            'fa_answer' => 'nullable|string',
            'fa_order' => 'nullable|integer',
            'display' => 'boolean',
            'active' => 'boolean',

            'fa_faq' => 'nullable|array',
            'fa_faq.faq_title' => 'nullable|string',
            'fa_faq.faq_subtitle' => 'nullable|string',
            'fa_faq.faq_sec' => 'nullable|integer|exists:tbsection,sec_id',
        ];
    }
}
