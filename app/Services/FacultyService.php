<?php

namespace App\Services;

use App\Models\Faculty;
use App\Models\FacultyContact;
use App\Models\FacultyInfo;
use App\Models\FacultyBg;
use App\Models\Social;
use Illuminate\Support\Facades\DB;

class FacultyService
{
    /**
     * Create a new faculty with nested relationships
     */
    public function createFaculty(array $data)
    {
        return DB::transaction(function () use (&$data) {

            if (!empty($data['f_contact']) && is_array($data['f_contact'])) {
                $contact = FacultyContact::create($data['f_contact']);
                $data['f_contact'] = $contact->fc_id;
            }

            if (!empty($data['f_info']) && is_array($data['f_info'])) {
                $info = FacultyInfo::create($data['f_info']);
                $data['f_info'] = $info->finfo_id;
            }

            if (!empty($data['f_bg']) && is_array($data['f_bg'])) {
                $bg = FacultyBg::create($data['f_bg']);
                $data['f_bg'] = $bg->fbg_id;
            }

            if (!empty($data['f_social']) && is_array($data['f_social'])) {
                $social = Social::create($data['f_social']);
                $data['f_social'] = $social->social_id;
            }

            return Faculty::create($data);
        });
    }

    /**
     * Update an existing faculty and its related data
     */
    public function updateFaculty(Faculty $faculty, array $data)
    {
        return DB::transaction(function () use ($faculty, &$data) {

            // Update or create FacultyContact
            if (!empty($data['f_contact']) && is_array($data['f_contact'])) {
                if ($faculty->f_contact) {
                    $contact = FacultyContact::find($faculty->f_contact);
                    $contact?->update($data['f_contact']);
                    $data['f_contact'] = $contact->fc_id ?? null;
                } else {
                    $contact = FacultyContact::create($data['f_contact']);
                    $data['f_contact'] = $contact->fc_id;
                }
            }

            // Update or create FacultyInfo
            if (!empty($data['f_info']) && is_array($data['f_info'])) {
                if ($faculty->f_info) {
                    $info = FacultyInfo::find($faculty->f_info);
                    $info?->update($data['f_info']);
                    $data['f_info'] = $info->finfo_id ?? null;
                } else {
                    $info = FacultyInfo::create($data['f_info']);
                    $data['f_info'] = $info->finfo_id;
                }
            }

            // Update or create FacultyBg
            if (!empty($data['f_bg']) && is_array($data['f_bg'])) {
                if ($faculty->f_bg) {
                    $bg = FacultyBg::find($faculty->f_bg);
                    $bg?->update($data['f_bg']);
                    $data['f_bg'] = $bg->fbg_id ?? null;
                } else {
                    $bg = FacultyBg::create($data['f_bg']);
                    $data['f_bg'] = $bg->fbg_id;
                }
            }

            // Update or create Social
            if (!empty($data['f_social']) && is_array($data['f_social'])) {
                if ($faculty->f_social) {
                    $social = Social::find($faculty->f_social);
                    $social?->update($data['f_social']);
                    $data['f_social'] = $social->social_id ?? null;
                } else {
                    $social = Social::create($data['f_social']);
                    $data['f_social'] = $social->social_id;
                }
            }

            // Finally update faculty
            $faculty->update($data);
            return $faculty;
        });
    }
}
