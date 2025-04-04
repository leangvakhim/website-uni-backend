<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'faq_sec' => 'nullable|array',
            'faq_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'faq_sec.sec_order' => 'nullable|integer',
            'faq_sec.lang' => 'nullable|in:1,2',
            'faq_sec.display' => 'required|boolean',
            'faq_sec.active' => 'required|boolean',

            'faq_title' => 'nullable|string|max:255',
            'faq_subtitle' => 'nullable|string',
        ];
    }
}
