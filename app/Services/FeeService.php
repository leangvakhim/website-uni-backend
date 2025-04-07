<?php

namespace App\Services;

use App\Models\Fee;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class FeeService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['fe_sec']) && is_array($data['fe_sec'])) {
                $section = Section::create($data['fe_sec']);
                $data['fe_sec'] = $section->sec_id;
            }
            return Fee::create($data);
        });
    }

    public function update(Fee $fee, array $data)
    {
        return DB::transaction(function () use ($fee, &$data) {
            if (!empty($data['fe_sec']) && is_array($data['fe_sec'])) {
                $section = Section::create($data['fe_sec']);
                $data['fe_sec'] = $section->sec_id;
            }
            $fee->update($data);
            return $fee;
        });
    }
}
