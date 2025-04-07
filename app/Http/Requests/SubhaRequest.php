<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubhaRequest extends FormRequest
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
            'sha_ha' => 'nullable|array',
            'sha_ha.ha_title' => 'nullable|string|max:255',
            'sha_ha.ha_img' => 'nullable|integer|exists:tbimage,image_id',
            'sha_ha.ha_tagtitle' => 'nullable|string|max:255',
            'sha_ha.ha_subtitletag' => 'nullable|string|max:255',
            'sha_ha.ha_date' => 'nullable|date',

            'sha_title' => 'nullable|string',
            'sha_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
