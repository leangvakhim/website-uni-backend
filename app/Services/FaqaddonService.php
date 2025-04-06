<?php
namespace App\Services;

use App\Models\Faq;
use App\Models\Faqaddon;
use Illuminate\Support\Facades\DB;

class FaqaddonService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['fa_faq']) && is_array($data['fa_faq'])) {
                $faq = Faq::create($data['fa_faq']);
                $data['fa_faq'] = $faq->faq_id;
            }

            return Faqaddon::create($data);
        });
    }

    public function update(Faqaddon $faqaddon, array $data)
    {
        return DB::transaction(function () use ($faqaddon, $data) {
            if (!empty($data['fa_faq']) && is_array($data['fa_faq'])) {
                $faq = Faq::create($data['fa_faq']);
                $data['fa_faq'] = $faq->faq_id;
            }

            $faqaddon->update($data);
            return $faqaddon;
        });
    }
}
