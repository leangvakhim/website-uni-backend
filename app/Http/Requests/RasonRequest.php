<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RasonRequest extends FormRequest
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
            'rason_title' => 'nullable|string',
            'rason_amount' => 'nullable|string',
            'rason_subtitle' => 'nullable|string'
        ];
    }
}
