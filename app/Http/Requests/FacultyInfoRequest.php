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
            'finfo_title' => 'nullable|string|max:255',
            'finfo_detail' => 'nullable|string',
            'finfo_side' => 'required||integer',
            'finfo_order' => 'required|integer',
            'active' => 'required|boolean',
            'display' => 'required|boolean',
           // 'finfo_f' => 'nullable|integer|exists:tbfaculty,f_id',

            
            'finfo_f' => 'nullable|array',
            'finfo_f.f_name' => 'nullable|string|max:255',
            'finfo_f.f_position' => 'nullable|string|max:100',
            'finfo_f.f_portfolio' => 'nullable|string',
            'finfo_f.f_img' => 'nullable|integer|exists:tbimage,image_id',
            'finfo_f.f_order' => 'nullable|integer',
            'finfo_f.lang' => 'nullable|integer|in:1,2',
            'finfo_f.display' => 'nullable|boolean',
            'finfo_f.active' => 'nullable|boolean',
        ];
    }
}
