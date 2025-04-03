<?php

namespace App\Services;

use App\Models\FacultyBg;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class FacultyBgService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['fbg_f']) && is_array($data['fbg_f'])) {
                $faculty = Faculty::create($data['fbg_f']);
                $data['fbg_f'] = $faculty->f_id;
            }

            return FacultyBg::create($data);
        });
    }

    public function update(FacultyBg $bg, array $data)
    {
        return DB::transaction(function () use ($bg, &$data) {
            if (!empty($data['fbg_f']) && is_array($data['fbg_f'])) {
                $faculty = Faculty::create($data['fbg_f']);
                $data['fbg_f'] = $faculty->f_id;
            }

            $bg->update($data);
            return $bg;
        });
    }
}
    