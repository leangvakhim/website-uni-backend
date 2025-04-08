<?php

namespace App\Services;

use App\Models\Subcontact;
use Illuminate\Support\Facades\DB;

class SubcontactService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Subcontact::create($data);
        });
    }

    public function update(Subcontact $subcontact, array $data)
    {
        return DB::transaction(function () use ($subcontact, $data) {
            $subcontact->update($data);
            return $subcontact;
        });
    }
}
