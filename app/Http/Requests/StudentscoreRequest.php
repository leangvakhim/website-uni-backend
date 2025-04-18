<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentscoreRequest extends FormRequest
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
            'student_id' => 'required|integer|exists:tbstudents,student_id', //student
            'result' => 'nullable|string|max:255', //student

            'subject_id' => 'required|integer|exists:tbsubjects,subject_id', //subject
            'subject_name' => 'nullable|string|max:255', //subject

            'score' => 'nullable|integer|min:0|max:100',
            'display' => 'nullable|boolean',
            'active' => 'nullable|boolean',

            'scores' => 'nullable|array',
            'scores.*.score' => 'nullable|integer|min:0|max:100',
            'scores.*.display' => 'nullable|boolean',
            'scores.*.active' => 'nullable|boolean'
        ];
    }
}
