<?php

namespace App\Services;

use App\Models\Subha;
use App\Models\Ha;
use Illuminate\Support\Facades\DB;

class SubhaService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['sha_ha']) && is_array($data['sha_ha'])) {
                $ha = Ha::create($data['sha_ha']);
                $data['sha_ha'] = $ha->ha_id;
            }

            return Subha::create($data);
        });
    }

    public function update(Subha $subha, array $data)
    {
        return DB::transaction(function () use ($subha, &$data) {
            if (!empty($data['sha_ha']) && is_array($data['sha_ha'])) {
                $ha = Ha::create($data['sha_ha']);
                $data['sha_ha'] = $ha->ha_id;
            }

            $subha->update($data);
            return $subha;
        });
    }
}
