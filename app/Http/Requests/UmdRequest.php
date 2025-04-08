<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmdRequest extends FormRequest
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
            'umd_sec' => 'nullable|array',
            'umd_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'umd_sec.sec_order' => 'nullable|integer',
            'umd_sec.lang' => 'nullable|integer|in:1,2',
            'umd_sec.display' => 'required|boolean',
            'umd_sec.active' => 'required|boolean',
    
            'umd_title' => 'nullable|string|max:100',
            'umd_detail' => 'nullable|string',
            'umd_routepage' => 'nullable|string|max:100',
            'umd_btntext' => 'nullable|string|max:20',
            'umd_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
