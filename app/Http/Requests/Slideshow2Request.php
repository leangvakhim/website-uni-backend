<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Slideshow2Request extends FormRequest
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
            'slider_title' => 'nullable|string|max:100',
            'slider_text' => 'nullable|string',
            'btn1' => 'nullable|array',
            'btn1.bss_title' => 'nullable|string|max:50',
            'btn1.bss_routepage' => 'nullable|string',

            'btn2' => 'nullable|array',
            'btn2.bss_title' => 'nullable|string|max:50',
            'btn2.bss_routepage' => 'nullable|string',

            'slider_sec' => 'nullable|array',
            'slider_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'slider_sec.sec_order' => 'nullable|integer',
            'slider_sec.lang' => 'nullable|integer|in:1,2',
            'slider_sec.display' => 'nullable|boolean',
            'slider_sec.active' => 'nullable|boolean',

            'img' => 'nullable|exists:tbimage,image_id',
            'logo' => 'nullable|exists:tbimage,image_id',
            'slider_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
