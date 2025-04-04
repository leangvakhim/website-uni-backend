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
            'fbg_name' => 'nullable|string|max:255',
            'fbg_img' => 'nullable|integer|exists:tbimage,image_id',
            'fbg_order' => 'nullable|integer',
            'active' => 'required|boolean',
            'display' => 'required|boolean',
          //'fbg_f' => 'nullable|integer|exists:tbfaculty,f_id',

            'fbg_f' => 'nullable|array',
            'fbg_f.f_name' => 'nullable|string|max:255',
            'fbg_f.f_position' => 'nullable|string|max:100',
            'fbg_f.f_portfolio' => 'nullable|string',
            'fbg_f.f_img' => 'nullable|integer|exists:tbimage,image_id',
            'fbg_f.f_order' => 'nullable|integer',
            'fbg_f.lang' => 'nullable|integer|in:1,2',
            'fbg_f.display' => 'nullable|boolean',
            'fbg_f.active' => 'nullable|boolean',
        ];
    }
}
