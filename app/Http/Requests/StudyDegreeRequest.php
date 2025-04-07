<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyDegreeRequest extends FormRequest
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
            'std_sec' => 'nullable|array',
            'std_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'std_sec.sec_order' => 'nullable|integer',
            'std_sec.lang' => 'nullable|integer|in:1,2',
            'std_sec.display' => 'required|boolean',
            'std_sec.active' => 'required|boolean',
    
            'std_title' => 'nullable|string|max:255',
            'std_subtitle' => 'nullable|string',
            'std_type' => 'nullable|integer|in:1,2',
        ];
    }
}
