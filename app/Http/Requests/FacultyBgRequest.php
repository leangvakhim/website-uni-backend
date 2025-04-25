<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyBgRequest extends FormRequest
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

            'f_id' => 'nullable|integer|exists:tbfaculty,f_id',
            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'lang' => 'nullable|integer|in:1,2',

            // Validate multiple contact records
            'facultyBG' => 'nullable|array',
            'facultyBG.*.fbg_img' => 'nullable|integer|exists:tbimage,image_id',
            'facultyBG.*.fbg_f' => 'nullable|integer|exists:tbfaculty,f_id',
            'facultyBG.*.fbg_name' => 'nullable|string|max:255',
            'facultyBG.*.fbg_order' => 'nullable|integer',

        ];
    }
}