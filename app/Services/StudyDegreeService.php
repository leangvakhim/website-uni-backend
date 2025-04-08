<?php
namespace App\Services;

use App\Models\StudyDegree;
use App\Models\Section;
use Illuminate\Support\Facades\DB;  

class StudyDegreeService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['std_sec']) && is_array($data['std_sec'])) {
                $sec = Section::create($data['std_sec']);
                $data['std_sec'] = $sec->sec_id;
            }

            return StudyDegree::create($data);
        });
    }

    public function update(StudyDegree $std, array $data)
    {
        return DB::transaction(function () use ($std, &$data) {
            if (!empty($data['std_sec']) && is_array($data['std_sec'])) {
                $sec = Section::create($data['std_sec']);
                $data['std_sec'] = $sec->sec_id;
            }

            $std->update($data);
            return $std;
        });
    }
}
