<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class RsdDescRequest extends FormRequest
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
            'research_desc' => 'nullable|array',
            'research_desc.*.rsdd_title' => 'nullable|string|max:255',
            'research_desc.*.rsdd_details' => 'nullable|string',
            'research_desc.*.rsdd_rsdtile' => 'nullable|integer',

        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('research_desc')) {
            $researchDesc = $this->input('research_desc');
            foreach ($researchDesc as $index => $item) {
                if (isset($item['rsdd_details'])) {
                    $researchDesc[$index]['rsdd_details'] = Purifier::clean($item['rsdd_details']);
                }
            }
            $this->merge(['research_desc' => $researchDesc]);
        }
    }
}