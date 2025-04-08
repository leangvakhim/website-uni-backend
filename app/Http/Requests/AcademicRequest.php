<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicRequest extends FormRequest
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
            'acad_sec' => 'nullable|array',
            'acad_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'acad_sec.sec_order' => 'nullable|integer',
            'acad_sec.lang' => 'nullable|in:1,2',
            'acad_sec.display' => 'required|boolean',
            'acad_sec.active' => 'required|boolean',

            'acad_title' => 'nullable|string|max:100',
            'acad_detail' => 'nullable|string',
            'acad_img' => 'nullable|integer|exists:tbimage,image_id',
            'acad_btntext1' => 'nullable|string|max:30',
            'acad_btntext2' => 'nullable|string|max:30',
            'acad_routepage' => 'nullable|string|max:100',
            'acad_routetext' => 'nullable|string|max:100',
        ];
    }
}
