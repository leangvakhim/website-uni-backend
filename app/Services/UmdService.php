<?php
namespace App\Services;

use App\Models\Umd;
use App\Models\Section;
use Illuminate\Support\Facades\DB;  

class UmdService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['umd_sec']) && is_array($data['umd_sec'])) {
                $sec = Section::create($data['umd_sec']);
                $data['umd_sec'] = $sec->sec_id;
            }

            return Umd::create($data);
        });
    }

    public function update(Umd $umd, array $data)
    {
        return DB::transaction(function () use ($umd, &$data) {
            if (!empty($data['umd_sec']) && is_array($data['umd_sec'])) {
                $sec = Section::create($data['umd_sec']);
                $data['umd_sec'] = $sec->sec_id;
            }

            $umd->update($data);
            return $umd;
        });
    }
}
