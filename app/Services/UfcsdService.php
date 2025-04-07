<?php

namespace App\Services;

use App\Models\Ufcsd;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class UfcsdService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['uf_sec']) && is_array($data['uf_sec'])) {
                $section = Section::create($data['uf_sec']);
                $data['uf_sec'] = $section->sec_id;
            }
            return Ufcsd::create($data);
        });
    }

    public function update(Ufcsd $ufcsd, array $data)
    {
        return DB::transaction(function () use ($ufcsd, &$data) {
            if (!empty($data['uf_sec']) && is_array($data['uf_sec'])) {
                $section = Section::create($data['uf_sec']);
                $data['uf_sec'] = $section->sec_id;
            }
            $ufcsd->update($data);
            return $ufcsd;
        });
    }
}
