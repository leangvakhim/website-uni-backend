<?php

namespace App\Services;

use App\Models\Year;
use App\Models\Studydegree;
use Illuminate\Support\Facades\DB;

class YearService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['y_std']) && is_array($data['y_std'])) {
                $std = Studydegree::create($data['y_std']);
                $data['y_std'] = $std->std_id;
            }
            return Year::create($data);
        });
    }

    public function update(Year $year, array $data)
    {
        return DB::transaction(function () use ($year, &$data) {
            if (!empty($data['y_std']) && is_array($data['y_std'])) {
                $std = Studydegree::create($data['y_std']);
                $data['y_std'] = $std->std_id;
            }
            $year->update($data);
            return $year;
        });
    }
}
