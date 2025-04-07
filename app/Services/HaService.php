<?php

namespace App\Services;

use App\Models\Ha;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class HaService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['ha_sec']) && is_array($data['ha_sec'])) {
                $section = Section::create($data['ha_sec']);
                $data['ha_sec'] = $section->sec_id;
            }
            return Ha::create($data);
        });
    }

    public function update(Ha $ha, array $data)
    {
        return DB::transaction(function () use ($ha, &$data) {
            if (!empty($data['ha_sec']) && is_array($data['ha_sec'])) {
                $section = Section::create($data['ha_sec']);
                $data['ha_sec'] = $section->sec_id;
            }
            $ha->update($data);
            return $ha;
        });
    }
}
