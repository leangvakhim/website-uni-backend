<?php

namespace App\Services;

use App\Models\Tse;
use App\Models\Section;
use App\Models\Text;
use Illuminate\Support\Facades\DB;

class TseService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['tse_sec']) && is_array($data['tse_sec'])) {
                $section = Section::create($data['tse_sec']);
                $data['tse_sec'] = $section->sec_id;
            }

            if (!empty($data['tse_text']) && is_array($data['tse_text'])) {
                $text = Text::create($data['tse_text']);
                $data['tse_text'] = $text->text_id;
            }

            return Tse::create($data);
        });
    }

    public function update(Tse $tse, array $data)
    {
        return DB::transaction(function () use ($tse, &$data) {
            if (!empty($data['tse_sec']) && is_array($data['tse_sec'])) {
                $section = Section::create($data['tse_sec']);
                $data['tse_sec'] = $section->sec_id;
            }

            if (!empty($data['tse_text']) && is_array($data['tse_text'])) {
                $text = Text::create($data['tse_text']);
                $data['tse_text'] = $text->text_id;
            }

            $tse->update($data);
            return $tse;
        });
    }
}
