<?php

namespace App\Services;

use App\Models\RsdDesc;
use App\Models\RsdTitle;
use Illuminate\Support\Facades\DB;

class RsdDescService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['rsdd_rsdtile']) && is_array($data['rsdd_rsdtile'])) {
                $title = RsdTitle::create($data['rsdd_rsdtile']);
                $data['rsdd_rsdtile'] = $title->rsdt_id;
            }

            return RsdDesc::create($data);
        });
    }

    public function update(RsdDesc $desc, array $data)
    {
        return DB::transaction(function () use ($desc, &$data) {
            if (!empty($data['rsdd_rsdtile']) && is_array($data['rsdd_rsdtile'])) {
                $title = RsdTitle::create($data['rsdd_rsdtile']);
                $data['rsdd_rsdtile'] = $title->rsdt_id;
            }

            $desc->update($data);
            return $desc;
        });
    }
}
