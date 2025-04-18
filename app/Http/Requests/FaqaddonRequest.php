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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'faq_title' => 'nullable|string',
            'faq_subtitle' => 'nullable|string',
            'faq_sec' => 'nullable|integer|exists:tbsection,sec_id',

            'faqaddon' => 'nullable|array',
            'faqaddon.*.fa_faq' => 'nullable|integer|exists:tbfaq,faq_id',
            'faqaddon.*.fa_question' => 'nullable|string',
            'faqaddon.*.fa_answer' => 'nullable|string',
            'faqaddon.*.display' => 'nullable|boolean',
            'faqaddon.*.active' => 'nullable|boolean',
            'faqaddon.*.fa_order' => 'nullable|integer',
        ];
    }
}
