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
            'fc_name' => 'nullable|string|max:255',
            'fc_order' => 'required|integer',
            'active' => 'required|boolean',
            'display' => 'required|boolean',
 
            'fc_f' => 'nullable|array',

            'fc_f.f_name' => 'nullable|string|max:255',
            'fc_f.f_position' => 'nullable|string|max:100',
            'fc_f.f_portfolio' => 'nullable|string',
            'fc_f.f_img' => 'nullable|integer|exists:tbimage,image_id',
            'fc_f.f_order' => 'nullable|integer',
            'fc_f.lang' => 'nullable|integer|in:1,2',
            'fc_f.display' => 'nullable|boolean',
            'fc_f.active' => 'nullable|boolean',
        ];
    }
}
