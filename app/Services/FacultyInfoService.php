<?php

namespace App\Services;

use App\Models\FacultyInfo;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class FacultyInfoService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['finfo_f']) && is_array($data['finfo_f'])) {
                $faculty = Faculty::create($data['finfo_f']);
                $data['finfo_f'] = $faculty->f_id;
            }

            return FacultyInfo::create($data);
        });
    }

    public function update(FacultyInfo $info, array $data)
    {
        return DB::transaction(function () use ($info, &$data) {
            if (!empty($data['finfo_f']) && is_array($data['finfo_f'])) {
                $faculty = Faculty::create($data['finfo_f']);
                $data['finfo_f'] = $faculty->f_id;
            }

            $info->update($data);
            return $info;
        });
    }
}
