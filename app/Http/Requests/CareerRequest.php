<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerRequest extends FormRequest
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
            'c_title' => 'nullable|string|max:255',
            'c_shorttitle' => 'nullable|string|max:255',
            'c_img' => 'nullable|integer|exists:tbimage,image_id',
            'c_date' => 'nullable|date',
            'c_detail' => 'nullable|string',
            'c_fav' => 'required|boolean',
            'lang' => 'nullable|integer',
            'ref_id' => 'nullable|integer',
            'c_order' => 'nullable|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean'
        ];
    }
}
