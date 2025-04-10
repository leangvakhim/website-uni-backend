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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'gallery' => 'nullable|array',
            'gallery.*.gal_text' => 'nullable|integer|exists:tbtext,text_id',
            'gallery.*.gal_sec' => 'nullable|integer|exists:tbsection,sec_id',        
            'gallery.*.gal_img1' => 'nullable|integer|exists:tbimage,image_id',
            'gallery.*.gal_img2' => 'nullable|integer|exists:tbimage,image_id',
            'gallery.*.gal_img3' => 'nullable|integer|exists:tbimage,image_id',
            'gallery.*.gal_img4' => 'nullable|integer|exists:tbimage,image_id',
            'gallery.*.gal_img5' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
