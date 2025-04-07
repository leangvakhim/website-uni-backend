<?php

namespace App\Services;

use App\Models\Subservice;
use App\Models\Ras;
use App\Models\Acadfacility;
use Illuminate\Support\Facades\DB;

class SubserviceService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['ss_ras']) && is_array($data['ss_ras'])) {
                $ras = Ras::create($data['ss_ras']);
                $data['ss_ras'] = $ras->ras_id;
            }

            if (!empty($data['ss_af']) && is_array($data['ss_af'])) {
                $af = Acadfacility::create($data['ss_af']);
                $data['ss_af'] = $af->af_id;
            }

            return Subservice::create($data);
        });
    }

    public function update(Subservice $subservice, array $data)
    {
        return DB::transaction(function () use ($subservice, $data) {
            if (!empty($data['ss_ras']) && is_array($data['ss_ras'])) {
                $ras = Ras::create($data['ss_ras']);
                $data['ss_ras'] = $ras->ras_id;
            }

            if (!empty($data['ss_af']) && is_array($data['ss_af'])) {
                $af = Acadfacility::create($data['ss_af']);
                $data['ss_af'] = $af->af_id;
            }

            $subservice->update($data);
            return $subservice;
        });
    }
}
