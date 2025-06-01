<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
            'am_title' => 'required|string|max:255',
            'am_shortdesc' => 'nullable|string|max:255',
            'am_detail' => 'nullable|string',
            'am_postdate' => 'nullable|date',
            'am_img' => 'nullable|integer|exists:tbimage,image_id',
            'am_fav' => 'nullable|boolean',
            'am_tag' => 'nullable|string',
            'lang' => 'nullable|integer',
            'ref_id' => 'nullable|integer',
            'am_orders' => 'nullable|integer',
            'display' => 'boolean',
            'active' => 'boolean'
        ];
    }
}
