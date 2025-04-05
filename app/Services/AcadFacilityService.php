<?php

namespace App\Services;

use App\Models\AcadFacility;
use App\Models\Section;
use App\Models\Text;
use Illuminate\Support\Facades\DB;

class AcadFacilityService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['af_sec']) && is_array($data['af_sec'])) {
                $section = Section::create($data['af_sec']);
                $data['af_sec'] = $section->sec_id;
            }

            if (!empty($data['af_text']) && is_array($data['af_text'])) {
                $text = Text::create($data['af_text']);
                $data['af_text'] = $text->text_id;
            }

            return AcadFacility::create($data);
        });
    }

    public function update(AcadFacility $acadFacility, array $data)
    {
        return DB::transaction(function () use ($acadFacility, &$data) {
            if (!empty($data['af_sec']) && is_array($data['af_sec'])) {
                $section = Section::create($data['af_sec']);
                $data['af_sec'] = $section->sec_id;
            }

            if (!empty($data['af_text']) && is_array($data['af_text'])) {
                $text = Text::create($data['af_text']);
                $data['af_text'] = $text->text_id;
            }

            $acadFacility->update($data);
            return $acadFacility;
        });
    }
}
