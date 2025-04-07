<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['dep_sec']) && is_array($data['dep_sec'])) {
                $section = Section::create($data['dep_sec']);
                $data['dep_sec'] = $section->sec_id;
            }
            return Department::create($data);
        });
    }

    public function update(Department $department, array $data)
    {
        return DB::transaction(function () use ($department, &$data) {
            if (!empty($data['dep_sec']) && is_array($data['dep_sec'])) {
                $section = Section::create($data['dep_sec']);
                $data['dep_sec'] = $section->sec_id;
            }
            $department->update($data);
            return $department;
        });
    }
}
