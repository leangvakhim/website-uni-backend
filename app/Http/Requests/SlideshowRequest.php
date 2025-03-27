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

            'slider_text' => 'nullable|array',
            'slider_text.title' => 'nullable|string|max:255',
            'slider_text.desc' => 'nullable|string',
            'slider_text.tag' => 'nullable|string|max:255',
            'slider_text.lang' => 'nullable|integer', 

            'btn1' => 'nullable|array',
            'btn1.btn_title' => 'nullable|string|max:255',
            'btn1.btn_url' => 'nullable|string',
            'btn1.lang' => 'nullable|integer',

            'btn2' => 'nullable|array',
            'btn2.btn_title' => 'nullable|string|max:255',
            'btn2.btn_url' => 'nullable|string',
            'btn2.lang' => 'nullable|integer',


            
        ];
    }
}
