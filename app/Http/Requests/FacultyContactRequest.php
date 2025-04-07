<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyContactRequest extends FormRequest
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
            'fc_f' => 'nullable|array',
            'fc_f.*.fc_name' => 'nullable|string|max:255',
            'fc_f.*.fc_order' => 'nullable|integer',


            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'f_order' => 'nullable|integer',
            'lang' => 'nullable|integer|in:1,2',
        ];
    }
}
