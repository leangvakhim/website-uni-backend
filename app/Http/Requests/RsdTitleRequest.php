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
            'rsd_id' => 'required|integer|exists:tbrsd,rsd_id',
            'rsd_title' => 'nullable|string|max:255',
            'rsd_subtitle' => 'nullable|string|max:255',
            'rsd_lead' => 'nullable|string|max:255',
            'rsd_img' => 'nullable|integer|exists:tbimage,image_id',
            'rsd_fav' => 'nullable|boolean',
            'lang' => 'nullable|integer|in:1,2',
            
            'rsdt_rsd' => 'nullable|array',
            'rsdt_rsd.rsdt_title' => 'nullable|string|max:255',
            'rsdt_rsd.rsdt_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}