<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsheadRequest extends FormRequest
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
            'ash_title' => 'nullable|string',
            'ash_subtitle' => 'nullable|string',
            'ash_routetitle' => 'nullable|string|max:50',
            'ash_routepage' => 'nullable|string',
        ];
    }
}
