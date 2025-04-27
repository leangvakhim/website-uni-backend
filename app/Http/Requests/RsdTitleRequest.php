<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdTitleRequest extends FormRequest
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
            'rsd_title' => 'nullable|string|max:255',
            'rsd_subtitle' => 'nullable|string|max:255',
            'rsd_lead' => 'nullable|string|max:255',
            'rsd_img' => 'nullable|integer|exists:tbimage,image_id',
            'rsd_fav' => 'nullable|boolean',
            'lang' => 'nullable|integer|in:1,2',

            'research_title' => 'nullable|array',
            'research_title.*.rsdt_title' => 'nullable|string|max:255',
            'research_title.*.rsdt_text' => 'nullable|integer|exists:tbrsd,rsd_id',
            'research_title.*.rsdt_type' => 'nullable|string|max:255',
            'research_title.*.rsdt_code' => 'nullable|string|max:255',
            'research_title.*.rsdt_order' => 'nullable|integer',
        ];
    }
}