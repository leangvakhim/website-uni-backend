<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScholarshipRequest extends FormRequest
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
            'sc_sponsor' => 'nullable|string|max:255',
            'sc_title' => 'nullable|string|max:255',
            'sc_shortdesc' => 'nullable|string|max:255',
            'sc_detail' => 'nullable|string',
            'sc_deadline' => 'nullable|date',
            'sc_postdate' => 'nullable|date',
            'sc_img' => 'nullable|integer',
            'scletter_img' => 'nullable|integer',
            'sc_fav' => 'nullable|boolean',
            'lang' => 'nullable|integer',
            'ref_id' => 'nullable|integer',
            'sc_orders' => 'nullable|integer',
            'display' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ];
    }
}
