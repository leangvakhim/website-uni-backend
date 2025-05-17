<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
           // 'fb_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'fb_title' => 'nullable|string|max:255',
            'fb_subtitle' => 'nullable|string',
            'fb_writer' => 'nullable|string|max:255',
            'fb_img' => 'nullable|integer|exists:tbimage,image_id',
            'fb_order' => 'nullable|integer',
            'lang' => 'nullable|integer|in:1,2',
            'display' => 'nullable|boolean',
            'active' => 'nullable|boolean',

            'fb_sec' => 'nullable|array',
            'fb_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'fb_sec.sec_order' => 'nullable|integer',
            'fb_sec.lang' => 'nullable|integer|in:1,2',
            'fb_sec.display' => 'nullable|boolean',
            'fb_sec.active' => 'nullable|boolean',
        ];
    }
}
