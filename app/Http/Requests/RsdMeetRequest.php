<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mews\Purifier\Facades\Purifier;

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

    protected function prepareForValidation()
    {
        if ($this->has('research_meet')) {
            $researchMeet = $this->input('research_meet');
            foreach ($researchMeet as $index => $item) {
                if (isset($item['rsdm_detail'])) {
                    $researchMeet[$index]['rsdm_detail'] = Purifier::clean($item['rsdm_detail']);
                }
            }
            $this->merge(['research_meet' => $researchMeet]);
        }
    }
}
