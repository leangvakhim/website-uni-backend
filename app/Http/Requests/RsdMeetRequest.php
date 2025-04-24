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
            'rsdm_detail' => 'nullable|string',
            'rsdm_img' => 'nullable|integer|exists:tbimage,image_id',

            'rsdm_faculty' => 'nullable',

            'rsdm_rsdtile' => 'nullable|integer|exists:tbrsd_title,rsdt_id',

            'rsdm_faculty' => 'nullable|integer|exists:tbfaculty_contact,fc_id',

            'rsdm_faculty' => 'nullable|array',
            'rsdm_faculty.fc_name' => 'nullable|string|max:100',
            'rsdm_faculty.fc_order' => 'nullable|integer',
            'rsdm_faculty.display' => 'nullable|boolean',
            'rsdm_faculty.active' => 'nullable|boolean',

            'active' => 'required|boolean',
        ];
    }
}
