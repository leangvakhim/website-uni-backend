<?php

namespace App\Services;

use App\Models\Text;
use App\Models\Button;
use App\Models\Slideshow;
use Illuminate\Support\Facades\DB;

class SlideshowService
{
    public function handleText(array $textData)
    {
        $text = Text::create($textData);
        return $text;
    }
    
    public function createSlideshow(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['slider_text']) && is_array($data['slider_text'])) {
                $text = $this->handleText($data['slider_text']); 
                $data['slider_text'] = $text->text_id;
            }

        if (!empty($data['btn1']) && is_array($data['btn1'])) {
            $button1 = Button::create($data['btn1']);
            $data['btn1'] = $button1->button_id;
        }

        if (!empty($data['btn2']) && is_array($data['btn2'])) {
            $button2 = Button::create($data['btn2']);
            $data['btn2'] = $button2->button_id;
        }
            return Slideshow::create($data);
        });
    }
    
    public function updateSlideshow(Slideshow $slideshow, array $data)
    {
        return DB::transaction(function () use ($slideshow, &$data) {
            if (isset($data['slider_text']) && is_array($data['slider_text'])) {
                $text = $this->handleText($data['slider_text']); 
                $data['slider_text'] = $text->text_id; 
            }
    
            if (!empty($data['btn1']) && is_array($data['btn1'])) {
                if ($slideshow->btn1) {
                    $button1 = Button::find($slideshow->btn1);
                    if ($button1) {
                        $button1->update($data['btn1']);
                        $data['btn1'] = $button1->button_id;
                    }
                } else {
                    $button1 = Button::create($data['btn1']);
                    $data['btn1'] = $button1->button_id;
                }
            }

            if (!empty($data['btn2']) && is_array($data['btn2'])) {
                if ($slideshow->btn2) {
                    $button2 = Button::find($slideshow->btn2);
                    if ($button2) {
                        $button2->update($data['btn2']);
                        $data['btn2'] = $button2->button_id;
                    }
                } else {
                    $button2 = Button::create($data['btn2']);
                    $data['btn2'] = $button2->button_id;
                }
            }
            $slideshow->update($data);
            
            return $slideshow;
        });
    }
    
}
