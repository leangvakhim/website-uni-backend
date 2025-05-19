<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

class RsdProjectRequest extends FormRequest
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
            'research_project' => 'nullable|array',
            'research_project.*.rsdp_rsdtile' => 'nullable|integer|exists:tbrsd_title,rsdt_id',
            'research_project.*.rsdp_detail' => 'nullable|string',
            'research_project.*.rsdp_title' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('research_project')) {
            $researchProject = $this->input('research_project');
            foreach ($researchProject as $index => $item) {
                if (isset($item['rsdp_detail'])) {
                    $researchProject[$index]['rsdp_detail'] = Purifier::clean($item['rsdp_detail']);
                }
            }
            $this->merge(['research_project' => $researchProject]);
        }
    }
}
