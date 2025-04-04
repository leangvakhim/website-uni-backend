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
            'hsec_sec' => 'nullable|array',
            'hsec_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'hsec_sec.sec_order' => 'nullable|integer',
            'hsec_sec.lang' => 'nullable|in:1,2',
            'hsec_sec.display' => 'nullable|boolean',
            'hsec_sec.active' => 'nullable|boolean',

            'hsec_title' => 'nullable|string|max:50',
            'hsec_subtitle' => 'nullable|string|max:255',
            'hsec_btntitle' => 'nullable|string|max:15',
            'hsec_routepage' => 'nullable|string',
        ];
    }
}
