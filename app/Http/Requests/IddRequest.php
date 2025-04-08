<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IddRequest extends FormRequest
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
            'idd_sec' => 'nullable|array',
            'idd_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'idd_sec.sec_order' => 'nullable|integer',
            'idd_sec.lang' => 'nullable|in:1,2',
            'idd_sec.display' => 'required|boolean',
            'idd_sec.active' => 'required|boolean',

            'idd_title' => 'nullable|string|max:255',
            'idd_subtitle' => 'nullable|string|max:255'
        ];
    }
}
