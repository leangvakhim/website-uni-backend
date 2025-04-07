<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\Section;
use App\Models\Text;
use Illuminate\Support\Facades\DB;

class GalleryService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['gal_sec']) && is_array($data['gal_sec'])) {
                $sec = Section::create($data['gal_sec']);
                $data['gal_sec'] = $sec->sec_id;
            }

            if (!empty($data['gal_text']) && is_array($data['gal_text'])) {
                $text = Text::create($data['gal_text']);
                $data['gal_text'] = $text->text_id;
            }

            return Gallery::create($data);
        });
    }

    public function update(Gallery $gallery, array $data)
    {
        return DB::transaction(function () use ($gallery, &$data) {
            if (!empty($data['gal_sec']) && is_array($data['gal_sec'])) {
                $sec = Section::create($data['gal_sec']);
                $data['gal_sec'] = $sec->sec_id;
            }

            if (!empty($data['gal_text']) && is_array($data['gal_text'])) {
                $text = Text::create($data['gal_text']);
                $data['gal_text'] = $text->text_id;
            }

            $gallery->update($data);
            return $gallery;
        });
    }
}
