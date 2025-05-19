<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class TextRequest extends FormRequest
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

            'texts' => 'nullable|array',
            'texts.*.title' => 'nullable|string|max:255',
            'texts.*.text_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'texts.*.desc' => 'nullable|string',
            'texts.*.text_type' => 'nullable|integer',
            'texts.*.tag' => 'nullable|string|max:255',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('texts')) {
            $texts = $this->input('texts');
            foreach ($texts as $index => $item) {
                if (isset($item['desc'])) {
                    $texts[$index]['desc'] = Purifier::clean($item['desc']);
                }
            }
            $this->merge(['texts' => $texts]);
        }
    }
}
