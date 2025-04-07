<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'gal_sec' => 'nullable|array',
            'gal_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'gal_sec.sec_order' => 'nullable|integer',
            'gal_sec.lang' => 'nullable|in:1,2',
            'gal_sec.display' => 'required|boolean',
            'gal_sec.active' => 'required|boolean',

            'gal_text' => 'nullable|array',
            'gal_text.title' => 'nullable|string|max:255',
            'gal_text.desc' => 'nullable|string',
            'gal_text.text_type' => 'nullable|integer|in:1,2',
            'gal_text.tag' => 'nullable|string|max:255',
            'gal_text.lang' => 'nullable|integer|in:1,2',
        
            'gal_img1' => 'nullable|integer|exists:tbimage,image_id',
            'gal_img2' => 'nullable|integer|exists:tbimage,image_id',
            'gal_img3' => 'nullable|integer|exists:tbimage,image_id',
            'gal_img4' => 'nullable|integer|exists:tbimage,image_id',
            'gal_img5' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
