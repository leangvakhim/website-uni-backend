<?php

namespace App\Services;

use App\Models\Rsd;
use App\Models\RsdTitle;
use Illuminate\Support\Facades\DB;

class RsdService
{
    /**
     * Create a new RSD record with optional nested RsdTitle.
     */
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['rsd_text']) && is_array($data['rsd_text'])) {
                $title = RsdTitle::create($data['rsd_text']);
                $data['rsd_text'] = $title->rsdt_id;
            }

            return Rsd::create($data);
        });
    }

    /**
     * Update an existing RSD record and optionally its RsdTitle.
     */
    public function update(Rsd $rsd, array $data)
    {
        return DB::transaction(function () use ($rsd, &$data) {
            if (!empty($data['rsd_text']) && is_array($data['rsd_text'])) {
                $title = RsdTitle::create($data['rsd_text']);
                $data['rsd_text'] = $title->rsdt_id;
            }

            $rsd->update($data);
            return $rsd;
        });
    }
}
