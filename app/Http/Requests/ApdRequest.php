<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApdRequest extends FormRequest
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
            'apd_sec' => 'nullable|array',
            'apd_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'apd_sec.sec_order' => 'nullable|integer',
            'apd_sec.lang' => 'nullable|in:1,2',
            'apd_sec.display' => 'required|boolean',
            'apd_sec.active' => 'required|boolean',

            'apd_title' => 'nullable|string|max:100',
        ];
    }
}
