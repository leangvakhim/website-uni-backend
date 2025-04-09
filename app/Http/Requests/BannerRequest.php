<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'banners' => 'nullable|array',
            'banners.*.ban_img' => 'nullable|integer|exists:tbimage,image_id',
            'banners.*.ban_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'banners.*.ban_subtitle' => 'nullable|string|max:255',
            'banners.*.ban_title' => 'nullable|string|max:255'
        ];
    }
}
