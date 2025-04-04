<?php

namespace App\Services;

use App\Models\Section;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['sec_page']) && is_array($data['sec_page'])) {
                $page = Page::create($data['sec_page']);
                $data['sec_page'] = $page->p_id;
            }

            return Section::create($data);
        });
    }

    public function update(Section $section, array $data)
    {
        return DB::transaction(function () use ($section, &$data) {
            if (!empty($data['sec_page']) && is_array($data['sec_page'])) {
                $page = Page::create($data['sec_page']);
                $data['sec_page'] = $page->p_id;
            }

            $section->update($data);
            return $section;
        });
    }
}
