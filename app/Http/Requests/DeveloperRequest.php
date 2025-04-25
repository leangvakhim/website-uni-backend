<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeveloperRequest extends FormRequest
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

            'developer' => 'nullable|array',
            'developer.*.d_name' => 'nullable|string|max:50',
            'developer.*.d_position' => 'nullable|string|max:50',
            'developer.*.d_write' => 'nullable|string',
            'developer.*.d_img' => 'nullable|integer|exists:tbimage,image_id',
            'developer.*.lang' => 'nullable|in:1,2',
            'developer.*.d_order' => 'nullable|integer',
            'developer.*.display' => 'nullable|boolean',
            'developer.*.active' => 'nullable|boolean',
        ];
    }
}
