<?php

namespace App\Services;

use App\Models\Apd;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class ApdService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['apd_sec']) && is_array($data['apd_sec'])) {
                $section = Section::create($data['apd_sec']);
                $data['apd_sec'] = $section->sec_id;
            }
            return Apd::create($data);
        });
    }

    public function update(Apd $apd, array $data)
    {
        return DB::transaction(function () use ($apd, &$data) {
            if (!empty($data['apd_sec']) && is_array($data['apd_sec'])) {
                $section = Section::create($data['apd_sec']);
                $data['apd_sec'] = $section->sec_id;
            }
            $apd->update($data);
            return $apd;
        });
    }
}
