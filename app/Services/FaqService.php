<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class FaqService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['faq_sec']) && is_array($data['faq_sec'])) {
                $section = Section::create($data['faq_sec']);
                $data['faq_sec'] = $section->sec_id;
            }
            return Faq::create($data);
        });
    }

    public function update(Faq $faq, array $data)
    {
        return DB::transaction(function () use ($faq, &$data) {
            if (!empty($data['faq_sec']) && is_array($data['faq_sec'])) {
                $section = Section::create($data['faq_sec']);
                $data['faq_sec'] = $section->sec_id;
            }
            $faq->update($data);
            return $faq;
        });
    }
}
