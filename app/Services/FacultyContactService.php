<?php

namespace App\Services;

use App\Models\FacultyContact;
use App\Models\Faculty;
use Illuminate\Support\Facades\DB;

class FacultyContactService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['fc_f']) && is_array($data['fc_f'])) {
                $faculty = Faculty::create($data['fc_f']);
                $data['fc_f'] = $faculty->f_id;
            }

            return FacultyContact::create($data);
        });
    }

    public function update(FacultyContact $contact, array $data)
    {
        return DB::transaction(function () use ($contact, &$data) {
            if (!empty($data['fc_f']) && is_array($data['fc_f'])) {
                $faculty = Faculty::create($data['fc_f']);
                $data['fc_f'] = $faculty->f_id;
            }

            $contact->update($data);
            return $contact;
        });
    }
}
