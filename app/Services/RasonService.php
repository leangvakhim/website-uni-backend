<?php

namespace App\Services;

use App\Models\Rason;
use App\Models\Ras;
use Illuminate\Support\Facades\DB;

class RasonService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create nested ras if provided as object
            if (!empty($data['rason_ras']) && is_array($data['rason_ras'])) {
                $ras = Ras::create($data['rason_ras']);
                $data['rason_ras'] = $ras->ras_id;
            }

            return Rason::create($data);
        });
    }

    public function update(Rason $rason, array $data)
    {
        return DB::transaction(function () use ($rason, $data) {
            // Create nested ras if provided as object
            if (!empty($data['rason_ras']) && is_array($data['rason_ras'])) {
                $ras = Ras::create($data['rason_ras']);
                $data['rason_ras'] = $ras->ras_id;
            }

            $rason->update($data);
            return $rason;
        });
    }
}
