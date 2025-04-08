<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'dep_sec' => 'nullable|array',
            'dep_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'dep_sec.sec_order' => 'nullable|integer',
            'dep_sec.lang' => 'nullable|in:1,2',
            'dep_sec.display' => 'required|boolean',
            'dep_sec.active' => 'required|boolean',

            'dep_title' => 'nullable|string|max:100',
            'dep_detail' => 'nullable|string',
            'dep_img1' => 'nullable|integer|exists:tbimage,image_id',
            'dep_img2' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
