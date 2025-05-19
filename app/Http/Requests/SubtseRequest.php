<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class SubtseRequest extends FormRequest
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

            'tse_text' => 'nullable|integer|exists:tbtext,text_id',
            'tse_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'tse_type' => 'nullable|integer',

            'subtse' => 'nullable|array',
            'subtse.*.stse_tse' => 'nullable|integer|exists:tbtse,tse_id',
            'subtse.*.stse_title' => 'nullable|string',
            'subtse.*.stse_detail' => 'nullable|string',
            'subtse.*.stse_order' => 'nullable|integer',
            'subtse.*.display' => 'nullable|integer',
            'subtse.*.active' => 'nullable|integer',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('subtse')) {
            $subtse = $this->input('subtse');
            foreach ($subtse as $index => $item) {
                if (isset($item['stse_detail'])) {
                    $subtse[$index]['stse_detail'] = Purifier::clean($item['stse_detail']);
                }
            }
            $this->merge(['subtse' => $subtse]);
        }
    }
}
