<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RsdMeetRequest extends FormRequest
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
            'research_meet' => 'nullable|array',
            'research_meet.*.rsdm_rsdtitle' => 'nullable|integer|exists:tbrsd_title,rsdt_id',
            'research_meet.*.rsdm_detail' => 'nullable|string',
            'research_meet.*.rsdm_title' => 'nullable|string',
            'research_meet.*.rsdm_img' => 'nullable|integer|exists:tbimage,image_id',
        ];
    }
}
