<?php

namespace App\Services;

use App\Models\Subidd;
use App\Models\Idd;
use Illuminate\Support\Facades\DB;

class SubiddService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['sidd_idd']) && is_array($data['sidd_idd'])) {
                $idd = Idd::create($data['sidd_idd']);
                $data['sidd_idd'] = $idd->idd_id;
            }

            return Subidd::create($data);
        });
    }

    public function update(Subidd $subidd, array $data)
    {
        return DB::transaction(function () use ($subidd, &$data) {
            if (!empty($data['sidd_idd']) && is_array($data['sidd_idd'])) {
                $idd = Idd::create($data['sidd_idd']);
                $data['sidd_idd'] = $idd->idd_id;
            }

            $subidd->update($data);
            return $subidd;
        });
    }
}
