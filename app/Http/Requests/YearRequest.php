<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class YearRequest extends FormRequest
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

            'std_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'std_title' => 'nullable|string|max:255',
            'std_subtitle' => 'nullable|string',
            'std_type' => 'nullable|integer',

            'year' => 'nullable|array',
            'year.*.y_std' => 'nullable|integer|exists:tbstudydegree,std_id',
            'year.*.y_title' => 'nullable|string|max:255',
            'year.*.y_subtitle' => 'nullable|string',
            'year.*.y_detail' => 'nullable|string',
            'year.*.display' => 'nullable|integer',
            'year.*.active' => 'nullable|boolean',
            'year.*.y_order' => 'nullable|integer',

        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('year')) {
            $year = $this->input('year');
            foreach ($year as $index => $item) {
                if (isset($item['y_detail'])) {
                    $year[$index]['y_detail'] = Purifier::clean($item['y_detail']);
                }
            }
            $this->merge(['year' => $year]);
        }
    }
}
