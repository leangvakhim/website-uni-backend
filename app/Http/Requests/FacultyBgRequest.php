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
            
            'f_id' => 'required|integer|exists:tbfaculty,f_id',
            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'lang' => 'nullable|integer|in:1,2',

            // Validate multiple contact records
            'fbg_f' => 'nullable|array',
            'fbg_f.*.fbg_img' => 'nullable|integer|exists:tbimage,image_id',
            'fbg_f.*.fbg_name' => 'nullable|string|max:255',
            'fbg_f.*.fbg_order' => 'nullable|integer',
             
        ];
    }
}