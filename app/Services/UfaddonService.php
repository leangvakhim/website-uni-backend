<?php

namespace App\Services;

use App\Models\Ufaddon;
use App\Models\Ufcsd;
use Illuminate\Support\Facades\DB;

class UfaddonService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['ufa_uf']) && is_array($data['ufa_uf'])) {
                $uf = Ufcsd::create($data['ufa_uf']);
                $data['ufa_uf'] = $uf->uf_id;
            }
            return Ufaddon::create($data);
        });
    }

    public function update(Ufaddon $ufaddon, array $data)
    {
        return DB::transaction(function () use ($ufaddon, &$data) {
            if (!empty($data['ufa_uf']) && is_array($data['ufa_uf'])) {
                $uf = Ufcsd::create($data['ufa_uf']);
                $data['ufa_uf'] = $uf->uf_id;
            }
            $ufaddon->update($data);
            return $ufaddon;
        });
    }
}
