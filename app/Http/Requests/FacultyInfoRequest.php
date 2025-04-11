<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyInfoRequest extends FormRequest
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
            'f_id' => 'required|integer|exists:tbfaculty,f_id',
            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'lang' => 'nullable|integer|in:1,2',

            'finfo_f' => 'nullable|array',
            'finfo_f.*.finfo_title' => 'nullable|string|max:255',
            'finfo_f.*.finfo_detail' => 'nullable|string',
            'finfo_f.*.finfo_side' => 'required|integer',
            'finfo_f.*.finfo_order' => 'nullable|integer',
        ];
    }
}