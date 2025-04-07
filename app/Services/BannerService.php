<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class BannerService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['ban_sec']) && is_array($data['ban_sec'])) {
                $section = Section::create($data['ban_sec']);
                $data['ban_sec'] = $section->sec_id;
            }

            return Banner::create($data);
        });
    }

    public function update(Banner $banner, array $data)
    {
        return DB::transaction(function () use ($banner, &$data) {
            if (!empty($data['ban_sec']) && is_array($data['ban_sec'])) {
                $section = Section::create($data['ban_sec']);
                $data['ban_sec'] = $section->sec_id;
            }

            $banner->update($data);
            return $banner;
        });
    }
}
