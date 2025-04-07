<?php

namespace App\Services;

use App\Models\Idd;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class IddService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['idd_sec']) && is_array($data['idd_sec'])) {
                $section = Section::create($data['idd_sec']);
                $data['idd_sec'] = $section->sec_id;
            }
            return Idd::create($data);
        });
    }

    public function update(Idd $idd, array $data)
    {
        return DB::transaction(function () use ($idd, &$data) {
            if (!empty($data['idd_sec']) && is_array($data['idd_sec'])) {
                $section = Section::create($data['idd_sec']);
                $data['idd_sec'] = $section->sec_id;
            }
            $idd->update($data);
            return $idd;
        });
    }
}
