<?php

namespace App\Services;

use App\Models\Subapd;
use App\Models\Apd;
use Illuminate\Support\Facades\DB;

class SubapdService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['sapd_apd']) && is_array($data['sapd_apd'])) {
                $apd = Apd::create($data['sapd_apd']);
                $data['sapd_apd'] = $apd->apd_id;
            }

            return Subapd::create($data);
        });
    }

    public function update(Subapd $subapd, array $data)
    {
        return DB::transaction(function () use ($subapd, $data) {
            if (!empty($data['sapd_apd']) && is_array($data['sapd_apd'])) {
                $apd = Apd::create($data['sapd_apd']);
                $data['sapd_apd'] = $apd->apd_id;
            }

            $subapd->update($data);
            return $subapd;
        });
    }
}
