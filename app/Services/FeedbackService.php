<?php

namespace App\Services;

use App\Models\Feedback;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class FeedbackService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['fb_sec']) && is_array($data['fb_sec'])) {
                $section = Section::create($data['fb_sec']);
                $data['fb_sec'] = $section->sec_id;
            }

            return Feedback::create($data);
        });
    }


    public function update(Feedback $feedback, array $data)
    {
        return DB::transaction(function () use ($feedback, &$data) {
            if (!empty($data['fb_sec']) && is_array($data['fb_sec'])) {
                $section = Section::create($data['fb_sec']);
                $data['fb_sec'] = $section->sec_id;
            }

            $feedback->update($data);
            return $feedback;
        });
    }
}
