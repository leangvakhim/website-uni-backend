<?php

namespace App\Services;

use App\Models\Intro;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class IntroService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['in_sec']) && is_array($data['in_sec'])) {
                $section = Section::create($data['in_sec']);
                $data['in_sec'] = $section->sec_id;
            }
            return Intro::create($data);
        });
    }

    public function update(Intro $intro, array $data)
    {
        return DB::transaction(function () use ($intro, &$data) {
            if (!empty($data['in_sec']) && is_array($data['in_sec'])) {
                $section = Section::create($data['in_sec']);
                $data['in_sec'] = $section->sec_id;
            }
            $intro->update($data);
            return $intro;
        });
    }
}
