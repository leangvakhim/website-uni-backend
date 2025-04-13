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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            // Validate multiple social records
            'Service' => 'nullable|array',
            'Service.*.s_title' => 'nullable|string|max:255',
            'Service.*.s_subtitle' => 'nullable|string',
            'Service.*.s_img' => 'nullable|integer|exists:tbimage,image_id',
            'Service.*.s_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'Service.*.s_order' => 'nullable|integer',
            'Service.*.display' => 'nullable|boolean',
            'Service.*.active' => 'nullable|boolean',
        ];
    }
}
