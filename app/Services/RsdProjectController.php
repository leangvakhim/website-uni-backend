<?php

namespace App\Services;

use App\Models\RsdProject;
use App\Models\RsdTitle;
use Illuminate\Support\Facades\DB;

class RsdProjectService
{
    /**
     * Create a new RSD Project with nested rsdt_title creation.
     */
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['rsdp_rsdtile']) && is_array($data['rsdp_rsdtile'])) {
                $title = RsdTitle::create($data['rsdp_rsdtile']);
                $data['rsdp_rsdtile'] = $title->rsdt_id;
            }

            return RsdProject::create($data);
        });
    }

    /**
     * Update an existing RSD Project and its nested rsdt_title if needed.
     */
    public function update(RsdProject $project, array $data)
    {
        return DB::transaction(function () use ($project, &$data) {
            if (!empty($data['rsdp_rsdtile']) && is_array($data['rsdp_rsdtile'])) {
                $title = RsdTitle::create($data['rsdp_rsdtile']);
                $data['rsdp_rsdtile'] = $title->rsdt_id;
            }

            $project->update($data);
            return $project;
        });
    }
}
