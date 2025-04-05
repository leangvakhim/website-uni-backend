<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class TestimonialService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['t_sec']) && is_array($data['t_sec'])) {
                $section = Section::create($data['t_sec']);
                $data['t_sec'] = $section->sec_id;
            }

            return Testimonial::create($data);
        });
    }

    public function update(Testimonial $testimonial, array $data)
    {
        return DB::transaction(function () use ($testimonial, &$data) {
            if (!empty($data['t_sec']) && is_array($data['t_sec'])) {
                $section = Section::create($data['t_sec']);
                $data['t_sec'] = $section->sec_id;
            }

            $testimonial->update($data);
            return $testimonial;
        });
    }
}
