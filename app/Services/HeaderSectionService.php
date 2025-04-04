<?php

namespace App\Services;

use App\Models\HeaderSection;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class HeaderSectionService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['hsec_sec']) && is_array($data['hsec_sec'])) {
                $section = Section::create($data['hsec_sec']);
                $data['hsec_sec'] = $section->sec_id;
            }
            return HeaderSection::create($data);
        });
    }

    public function update(HeaderSection $header, array $data)
    {
        return DB::transaction(function () use ($header, &$data) {
            if (!empty($data['hsec_sec']) && is_array($data['hsec_sec'])) {
                $section = Section::create($data['hsec_sec']);
                $data['hsec_sec'] = $section->sec_id;
            }
            $header->update($data);
            return $header;
        });
    }
}
