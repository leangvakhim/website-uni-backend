<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class DepartmentRequest extends FormRequest
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
            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            // Validate multiple social records
            'programs' => 'nullable|array',
            'programs.*.dep_img1' => 'nullable|integer|exists:tbimage,image_id',
            'programs.*.dep_img2' => 'nullable|integer|exists:tbimage,image_id',
            'programs.*.dep_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'programs.*.dep_detail' => 'nullable|string',
            'programs.*.dep_title' => 'nullable|string|max:255'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('programs')) {
            $programs = $this->input('programs');
            foreach ($programs as $index => $item) {
                if (isset($item['dep_detail'])) {
                    $programs[$index]['dep_detail'] = Purifier::clean($item['dep_detail']);
                }
            }
            $this->merge(['programs' => $programs]);
        }
    }
}
