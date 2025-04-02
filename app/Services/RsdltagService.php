<?php

namespace App\Services;

use App\Models\Rsdl;
use App\Models\Rsdltag;
use Illuminate\Support\Facades\DB;

class RsdltagService
{
    public function create(array $data)
    {
        return DB::transaction(function () use (&$data) {
            if (!empty($data['rsdlt_rsdl']) && is_array($data['rsdlt_rsdl'])) {
                $rsdl = Rsdl::create($data['rsdlt_rsdl']);
                $data['rsdlt_rsdl'] = $rsdl->rsdl_id;
            }
    
            return Rsdltag::create($data);
        });
    }
    

    public function update(Rsdltag $rsdltag, array $data)
    {
        return DB::transaction(function () use ($rsdltag, &$data) {
            if (!empty($data['rsdlt_rsdl']) && is_array($data['rsdlt_rsdl'])) {
                $rsdl = Rsdl::create($data['rsdlt_rsdl']);
                $data['rsdlt_rsdl'] = $rsdl->rsdl_id;
            }

            $rsdltag->update($data);
            return $rsdltag;
        });
    }
}
