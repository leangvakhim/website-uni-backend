<?php

namespace App\Services;

use App\Models\Ras;
use App\Models\Text;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class RasService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            if (!empty($data['ras_sec']) && is_array($data['ras_sec'])) {
                $section = Section::create($data['ras_sec']);
                $data['ras_sec'] = $section->sec_id;
            }

            if (!empty($data['ras_text']) && is_array($data['ras_text'])) {
                $text = Text::create($data['ras_text']);
                $data['ras_text'] = $text->text_id;
            }

            return Ras::create($data);
        });
    }

    public function update(Ras $ras, array $data)
    {
        return DB::transaction(function () use ($ras, $data) {
            if (!empty($data['ras_sec']) && is_array($data['ras_sec'])) {
                $section = Section::create($data['ras_sec']);
                $data['ras_sec'] = $section->sec_id;
            }

            if (!empty($data['ras_text']) && is_array($data['ras_text'])) {
                $text = Text::create($data['ras_text']);
                $data['ras_text'] = $text->text_id;
            }

            $ras->update($data);
            return $ras;
        });
    }
}
