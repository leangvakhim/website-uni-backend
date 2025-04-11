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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            // Validate multiple social records
            'Slideshow' => 'nullable|array',
            'Slideshow.*.slider_title' => 'nullable|string|max:255',
            'Slideshow.*.slider_text' => 'nullable|string',
            'Slideshow.*.btn1' => 'nullable|integer|exists:tbbtnss,bss_id',
            'Slideshow.*.btn2' => 'nullable|integer|exists:tbbtnss,bss_id',
            'Slideshow.*.img' => 'nullable|integer|exists:tbimage,image_id',
            'Slideshow.*.logo' => 'nullable|integer|exists:tbimage,image_id',
            'Slideshow.*.slider_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'Slideshow.*.display' => 'nullable|boolean',
            'Slideshow.*.active' => 'nullable|boolean',
        ];
    }
}
