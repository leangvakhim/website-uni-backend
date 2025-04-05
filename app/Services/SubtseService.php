<?php

namespace App\Services;

use App\Models\Subtse;
use App\Models\Tse;
use Illuminate\Support\Facades\DB;

class SubtseService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['stse_tse']) && is_array($data['stse_tse'])) {
                $tse = Tse::create($data['stse_tse']);
                $data['stse_tse'] = $tse->tse_id;
            }

            return Subtse::create($data);
        });
    }

    public function update(Subtse $subtse, array $data)
    {
        return DB::transaction(function () use ($subtse, &$data) {
            if (!empty($data['stse_tse']) && is_array($data['stse_tse'])) {
                $tse = Tse::create($data['stse_tse']);
                $data['stse_tse'] = $tse->tse_id;
            }

            $subtse->update($data);
            return $subtse;
        });
    }
}
