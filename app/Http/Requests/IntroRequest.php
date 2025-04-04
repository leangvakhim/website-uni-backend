<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntroRequest extends FormRequest
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
            'in_title' => 'nullable|string|max:255',
            'in_detail' => 'nullable|string',
            'in_img' => 'nullable|integer|exists:tbimage,image_id',
            'inadd_title' => 'nullable|string|max:50',
            'in_addsubtitle' => 'nullable|string|max:50',
    
            'in_sec' => 'nullable|array',
            'in_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'in_sec.sec_order' => 'nullable|integer',
            'in_sec.lang' => 'nullable|in:1,2',
            'in_sec.display' => 'required|boolean',
            'in_sec.active' => 'required|boolean',
        ];
    }
}
