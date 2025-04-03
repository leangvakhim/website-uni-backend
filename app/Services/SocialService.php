<?php
namespace App\Services;

use App\Models\Social;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class SocialService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['social_faculty']) && is_array($data['social_faculty'])) {
                $faculty = Faculty::create($data['social_faculty']);
                $data['social_faculty'] = $faculty->f_id;
            }

            return Social::create($data);
        });
    }

    public function update(Social $social, array $data)
    {
        return DB::transaction(function () use ($social, &$data) {
            if (!empty($data['social_faculty']) && is_array($data['social_faculty'])) {
                $faculty = Faculty::create($data['social_faculty']);
                $data['social_faculty'] = $faculty->f_id;
            }

            $social->update($data);
            return $social;
        });
    }
}
