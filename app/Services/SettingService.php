<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Social;
use Illuminate\Support\Facades\DB;

class SettingService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['set_social']) && is_array($data['set_social'])) {
                $social = Social::create($data['set_social']);
                $data['set_social'] = $social->social_id;
            }
            return Setting::create($data);
        });
    }

    public function update(Setting $setting, array $data)
    {
        return DB::transaction(function () use ($setting, &$data) {
            if (!empty($data['set_social']) && is_array($data['set_social'])) {
                $social = Social::create($data['set_social']);
                $data['set_social'] = $social->social_id;
            }
            $setting->update($data);
            return $setting;
        });
    }
}
