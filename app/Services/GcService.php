<?php

namespace App\Services;

use App\Models\Gc;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class GcService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['gc_sec']) && is_array($data['gc_sec'])) {
                $section = Section::create($data['gc_sec']);
                $data['gc_sec'] = $section->sec_id;
            }
            return Gc::create($data);
        });
    }

    public function update(Gc $gc, array $data)
    {
        return DB::transaction(function () use ($gc, &$data) {
            if (!empty($data['gc_sec']) && is_array($data['gc_sec'])) {
                $section = Section::create($data['gc_sec']);
                $data['gc_sec'] = $section->sec_id;
            }
            $gc->update($data);
            return $gc;
        });
    }
}
// Compare this snippet from app/Models/Gc.php: