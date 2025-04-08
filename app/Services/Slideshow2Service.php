<?php

namespace App\Services;

use App\Models\Btnss;
use App\Models\Slideshow2;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class Slideshow2Service
{
    public function createSlideshow(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['btn1']) && is_array($data['btn1'])) {
                $button1 = Btnss::create($data['btn1']);
                $data['btn1'] = $button1->bss_id;
            }

            if (!empty($data['btn2']) && is_array($data['btn2'])) {
                $button2 = Btnss::create($data['btn2']);
                $data['btn2'] = $button2->bss_id;
            }

            if (!empty($data['slider_sec']) && is_array($data['slider_sec'])) {
                $section = Section::create($data['slider_sec']);
                $data['slider_sec'] = $section->sec_id;
            }

            return Slideshow2::create($data);
        });
    }

    public function updateSlideshow(Slideshow2 $slideshow, array $data)
    {
        return DB::transaction(function () use ($slideshow, &$data) {
            if (!empty($data['btn1']) && is_array($data['btn1'])) {
                if ($slideshow->btn1) {
                    $button1 = Btnss::find($slideshow->btn1);
                    if ($button1) {
                        $button1->update($data['btn1']);
                        $data['btn1'] = $button1->bss_id;
                    }
                } else {
                    $button1 = Btnss::create($data['btn1']);
                    $data['btn1'] = $button1->bss_id;
                }
            }

            if (!empty($data['btn2']) && is_array($data['btn2'])) {
                if ($slideshow->btn2) {
                    $button2 = Btnss::find($slideshow->btn2);
                    if ($button2) {
                        $button2->update($data['btn2']);
                        $data['btn2'] = $button2->bss_id;
                    }
                } else {
                    $button2 = Btnss::create($data['btn2']);
                    $data['btn2'] = $button2->bss_id;
                }
            }

            if (!empty($data['slider_sec']) && is_array($data['slider_sec'])) {
                if ($slideshow->slider_sec) {
                    $section = Section::find($slideshow->slider_sec);
                    if ($section) {
                        $section->update($data['slider_sec']);
                        $data['slider_sec'] = $section->sec_id;
                    }
                } else {
                    $section = Section::create($data['slider_sec']);
                    $data['slider_sec'] = $section->sec_id;
                }
            }

            $slideshow->update($data);

            return $slideshow;
        });
    }
}
