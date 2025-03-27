<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'f_social' => 'nullable|integer|exists:tbsocial,social_id',
            'f_contact' => 'nullable|integer|exists:tbfaculty_contact,fc_id',
            'f_info' => 'nullable|integer|exists:tbfaculty_info,finfo_id',
            'f_bg' => 'nullable|integer|exists:tbfaculty_bg,fbg_id',
            'f_order' => 'required|integer',
            'lang' => 'nullable|integer|in:1,2',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
