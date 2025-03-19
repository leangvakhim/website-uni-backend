<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideshowRequest extends FormRequest
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
            'slider_text' => 'nullable|exists:tbtext,text_id',
            'btn1' => 'nullable|exists:tbbutton,button_id',
            'btn2' => 'nullable|exists:tbbutton,button_id',
            'img' => 'nullable|exists:tbimage,image_id',
            'logo' => 'nullable|exists:tbimage,image_id',
            'slider_order' => 'required|integer',
            'display' => 'required|boolean',
            'active' => 'required|boolean',
        ];
    }
}
