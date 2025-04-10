<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GcRequest extends FormRequest
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


            'criteria' => 'nullable|array',
            'criteria.*.gc_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'criteria.*.gc_title' => 'nullable|string|max:255',
            'criteria.*.gc_tag' => 'nullable|string|max:255',
            'criteria.*.gc_type' => 'nullable|integer',
            'criteria.*.gc_detail' => 'nullable|string',
            'criteria.*.gc_img1' => 'nullable|integer|exists:tbimage,image_id',
            'criteria.*.gc_img2' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
