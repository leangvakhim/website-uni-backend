<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GcaddonRequest extends FormRequest
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
            // 'gca_tag' => 'nullable|string|max:255',
            // 'gca_btntitle' => 'nullable|string|max:50',
            // 'gca_btnlink' => 'nullable|string',

            // 'gca_gc' => 'nullable|array',
            // 'gca_gc.gc_sec' => 'nullable|integer|exists:tbsection,sec_id',
            // 'gca_gc.gc_title' => 'nullable|string|max:255',
            // 'gca_gc.gc_tag' => 'nullable|string|max:100',
            // 'gca_gc.gc_type' => 'nullable|in:1,2',
            // 'gca_gc.gc_detail' => 'nullable|string',
            // 'gca_gc.gc_img1' => 'nullable|integer|exists:tbimage,image_id',
            // 'gca_gc.gc_img2' => 'nullable|integer|exists:tbimage,image_id',

            'display' => 'nullable|boolean',
            'sec_page' => 'nullable|integer|exists:tbpage,p_id',
            'sec_order' => 'nullable|integer',

            'gc_sec' => 'nullable|integer|exists:tbsection,sec_id',
            'gc_img1' => 'nullable|integer|exists:tbimage,image_id',
            'gc_img2' => 'nullable|integer|exists:tbimage,image_id',
            'gc_title' => 'nullable|string',
            'gc_tag' => 'nullable|string',
            'gc_type' => 'nullable|integer',
            'gc_detail' => 'nullable|string',

            'gcaddon' => 'nullable|array',
            'gcaddon.*.gca_gc' => 'nullable|integer|exists:tbgc,gc_id',
            'gcaddon.*.gca_tag' => 'nullable|string',
            'gcaddon.*.gca_btntitle' => 'nullable|string',
            'gcaddon.*.gca_btnlink' => 'nullable|string',
        ];
    }
}
