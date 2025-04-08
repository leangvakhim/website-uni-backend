<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['s_sec']) && is_array($data['s_sec'])) {
                $section = Section::create($data['s_sec']);
                $data['s_sec'] = $section->sec_id;
            }
            return Service::create($data);
        });
    }

    public function update(Service $service, array $data)
    {
        return DB::transaction(function () use ($service, &$data) {
            if (!empty($data['s_sec']) && is_array($data['s_sec'])) {
                $section = Section::create($data['s_sec']);
                $data['s_sec'] = $section->sec_id;
            }
            $service->update($data);
            return $service;
        });
    }
}
