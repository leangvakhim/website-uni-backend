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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'academics' => 'nullable|array',
            'academics.*.acad_title' => 'nullable|string|max:100',
            'academics.*.acad_detail' => 'nullable|string',
            'academics.*.acad_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'academics.*.acad_img' => 'nullable|integer|exists:tbimage,image_id',
            'academics.*.acad_btntext1' => 'nullable|string|max:30',
            'academics.*.acad_btntext2' => 'nullable|string|max:30',
            'academics.*.acad_routepage' => 'nullable|string|max:100',
            'academics.*.acad_routetext' => 'nullable|string|max:100',
        ];
    }
}
