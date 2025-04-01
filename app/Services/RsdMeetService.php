<?php

namespace App\Services;

use App\Models\RsdMeet;
use App\Models\FacultyContact;
use Illuminate\Support\Facades\DB;

class RsdMeetService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['rsdm_faculty']) && is_array($data['rsdm_faculty'])) {
                $faculty = FacultyContact::create($data['rsdm_faculty']);
                $data['rsdm_faculty'] = $faculty->fc_id;
            }

            return RsdMeet::create($data);
        });
    }

    public function update(RsdMeet $rsdMeet, array $data)
    {
        return DB::transaction(function () use ($rsdMeet, &$data) {
            // Handle faculty
            if (!empty($data['rsdm_faculty']) && is_array($data['rsdm_faculty'])) {
                if (!empty($rsdMeet->rsdm_faculty)) {
                    // Existing faculty ID present, update it
                    $faculty = FacultyContact::find($rsdMeet->rsdm_faculty);
                    $faculty?->update($data['rsdm_faculty']);
                    $data['rsdm_faculty'] = $faculty->fc_id;
                } else {
                    // Create new faculty and assign ID
                    $faculty = FacultyContact::create($data['rsdm_faculty']);
                    $data['rsdm_faculty'] = $faculty->fc_id;
                }
            }
    
            $rsdMeet->update($data);
            return $rsdMeet;
        });
    }
    
}
