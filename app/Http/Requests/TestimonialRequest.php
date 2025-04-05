<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            't_title' => 'nullable|string|max:255',

            't_sec' => 'nullable|array',
            't_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            't_sec.sec_order' => 'nullable|integer',
            't_sec.lang' => 'nullable|in:1,2',
            't_sec.display' => 'required_with:t_sec|boolean',
            't_sec.active' => 'required_with:t_sec|boolean',
        ];
    }
}
