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
            'gc_title' => 'nullable|string|max:255',
            'gc_tag' => 'nullable|string|max:100',
            'gc_type' => 'nullable|in:1,2',
            'gc_detail' => 'nullable|string',

            'gc_sec' => 'nullable|array',
            'gc_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'gc_sec.sec_order' => 'nullable|integer',
            'gc_sec.lang' => 'nullable|in:1,2',
            'gc_sec.display' => 'required|boolean',
            'gc_sec.active' => 'required|boolean',

            'gc_img1' => 'nullable|integer|exists:tbimage,image_id',
            'gc_img2' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
