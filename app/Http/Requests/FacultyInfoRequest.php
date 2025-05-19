<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class FacultyInfoRequest extends FormRequest
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
            'f_id' => 'required|integer|exists:tbfaculty,f_id',
            'f_name' => 'nullable|string|max:255',
            'f_position' => 'nullable|string|max:100',
            'f_portfolio' => 'nullable|string',
            'f_img' => 'nullable|integer|exists:tbimage,image_id',
            'lang' => 'nullable|integer|in:1,2',

            'finfo_f' => 'nullable|array',
            'finfo_f.*.finfo_title' => 'nullable|string|max:255',
            'finfo_f.*.finfo_detail' => 'nullable|string',
            'finfo_f.*.finfo_side' => 'nullable|integer',
            'finfo_f.*.finfo_order' => 'nullable|integer',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->has('finfo_f')) {
            $finfo = $this->input('finfo_f');
            foreach ($finfo as $index => $item) {
                if (isset($item['finfo_detail'])) {
                    $finfo[$index]['finfo_detail'] = Purifier::clean($item['finfo_detail']);
                }
            }
            $this->merge(['finfo_f' => $finfo]);
        }
    }
}
    /**
     * Prepare the data for validation.
     */
