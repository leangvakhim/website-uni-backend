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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'idd_title' => 'nullable|string|max:255',
            'idd_subtitle' => 'nullable|string|max:255',
            'idd_sec' => 'nullable|integer|exists:tbsection,sec_id',

            'subimportant' => 'nullable|array',
            'subimportant.*.sidd_idd' => 'nullable|integer|exists:tbidd,idd_id',
            'subimportant.*.sidd_title' => 'nullable|string|max:255',
            'subimportant.*.sidd_subtitle' => 'nullable|string|max:255',
            'subimportant.*.sidd_tag' => 'nullable|string|max:255',
            'subimportant.*.sidd_date' => 'nullable|date',
            'subimportant.*.sidd_order' => 'nullable|integer',
            'subimportant.*.display' => 'nullable|boolean',
            'subimportant.*.active' => 'nullable|boolean',
        ];
    }
}
