<?php
namespace App\Services;

use App\Models\Academic;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class AcademicService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['acad_sec']) && is_array($data['acad_sec'])) {
                $sec = Section::create($data['acad_sec']);
                $data['acad_sec'] = $sec->sec_id;
            }

            return Academic::create($data);
        });
    }

    public function update(Academic $academic, array $data)
    {
        return DB::transaction(function () use ($academic, &$data) {
            if (!empty($data['acad_sec']) && is_array($data['acad_sec'])) {
                $sec = Section::create($data['acad_sec']);
                $data['acad_sec'] = $sec->sec_id;
            }

            $academic->update($data);
            return $academic;
        });
    }
}
