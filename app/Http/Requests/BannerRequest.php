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
            'ban_title' => 'nullable|string|max:255',
            'ban_subtitle' => 'nullable|string|max:255',
            'ban_img' => 'nullable|integer|exists:tbimage,image_id',

            'ban_sec' => 'nullable|array',
            'ban_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'ban_sec.sec_order' => 'nullable|integer',
            'ban_sec.lang' => 'nullable|in:1,2',
            'ban_sec.display' => 'required_with:ban_sec|boolean',
            'ban_sec.active' => 'required_with:ban_sec|boolean',
        ];
    }
}
