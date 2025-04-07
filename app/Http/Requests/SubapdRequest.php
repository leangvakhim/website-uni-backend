<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubapdRequest extends FormRequest
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
            'sapd_title' => 'nullable|string|max:50',
            'sapd_img' => 'nullable|integer|exists:tbimage,image_id',
            'sapd_routepage' => 'nullable|string',
            'sapd_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',

            'sapd_apd' => 'nullable|array',
            'sapd_apd.apd_title' => 'nullable|string|max:100',
            'sapd_apd.apd_sec' => 'nullable|integer|exists:tbsection,sec_id',
        ];
    }
}
