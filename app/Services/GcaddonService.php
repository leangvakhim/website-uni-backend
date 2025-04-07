<?php

namespace App\Services;

use App\Models\Gcaddon;
use App\Models\Gc;
use Illuminate\Support\Facades\DB;

class GcaddonService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['gca_gc'])) {
                $gcData = $data['gca_gc'];
                $gc = Gc::create($gcData);
                $data['gca_gc'] = $gc->gc_id;
            }

            return Gcaddon::create($data);
        });
    }

    public function update(Gcaddon $addon, array $data)
    {
        return DB::transaction(function () use ($addon, $data) {
            if (isset($data['gca_gc'])) {
                $gcData = $data['gca_gc'];
                $gc = Gc::create($gcData);
                $data['gca_gc'] = $gc->gc_id;
            }

            $addon->update($data);
            return $addon;
        });
    }
}
