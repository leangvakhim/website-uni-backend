<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubiddRequest extends FormRequest
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
            'sidd_title' => 'nullable|string|max:255',
            'sidd_subtitle' => 'nullable|string|max:255',
            'sidd_tag' => 'nullable|string|max:255',
            'sidd_date' => 'nullable|date',
            'sidd_order' => 'nullable|integer',

            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'sidd_idd' => 'nullable|array',
            'sidd_idd.idd_title' => 'nullable|string|max:255',
            'sidd_idd.idd_subtitle' => 'nullable|string|max:255',
            'sidd_idd.idd_sec' => 'nullable|integer|exists:tbsection,sec_id',

        ];
    }
}
