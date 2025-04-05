<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            's_title' => 'required|string|max:255',
            's_subtitle' => 'required|string|max:255',
            's_img' => 'nullable|integer|exists:tbimage,image_id',
            's_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            's_sec' => 'nullable|array',
            's_sec.sec_page' => 'sometimes|integer|exists:tbpage,p_id',
            's_sec.sec_order' => 'sometimes|integer',
            's_sec.lang' => 'sometimes|in:1,2',
            's_sec.display' => 'sometimes|boolean',
            's_sec.active' => 'sometimes|boolean',
        ];
    }
}
