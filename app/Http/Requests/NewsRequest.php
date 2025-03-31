<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'n_title' => 'nullable|string|max:255',
            'n_shorttitle' => 'nullable|string|max:255',
            'n_img' => 'nullable|exists:tbimage,image_id',
            'n_tags' => 'nullable|string|max:50',
            'n_date' => 'nullable|date',
            'n_detail' => 'nullable|string',
            'n_fav' => 'required|boolean',
            'lang' => 'nullable|integer',
            'n_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean'
        ];
    }
}
