<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Subcontact;
use Illuminate\Support\Facades\DB;

class ContactService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['con_addon']) && is_array($data['con_addon'])) {
                $sub = Subcontact::create($data['con_addon']);
                $data['con_addon'] = $sub->scon_id;
            }
            return Contact::create($data);
        });
    }

    public function update(Contact $contact, array $data)
    {
        return DB::transaction(function () use ($contact, &$data) {
            if (!empty($data['con_addon']) && is_array($data['con_addon'])) {
                $sub = Subcontact::create($data['con_addon']);
                $data['con_addon'] = $sub->scon_id;
            }
            $contact->update($data);
            return $contact;
        });
    }
}
