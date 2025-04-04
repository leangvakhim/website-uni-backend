<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HaRequest extends FormRequest
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
            'ha_title' => 'nullable|string|max:255',
            'ha_img' => 'nullable|integer|exists:tbimage,image_id',
            'ha_tagtitle' => 'nullable|string|max:255',
            'ha_subtitletag' => 'nullable|string|max:255',
            'ha_date' => 'nullable|date',
    
            'ha_sec' => 'nullable|array',
            'ha_sec.sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'ha_sec.sec_order' => 'nullable|integer',
            'ha_sec.lang' => 'nullable|in:1,2',
            'ha_sec.display' => 'required|boolean',
            'ha_sec.active' => 'required|boolean',
        ];
    }
}
