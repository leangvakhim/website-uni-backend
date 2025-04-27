<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RsdProject extends Model
{
    use HasFactory;
    protected $table = 'tbrsd_project';
    protected $primaryKey = 'rsdp_id';
    protected $fillable = ['rsdp_rsdtile', 'rsdp_detail', 'active', 'rsdp_title'];

    public function title()
    {
        return $this->belongsTo(RsdTitle::class, 'rsdp_rsdtile', 'rsdt_id')->select(['rsdt_id', 'rsdt_text']);
    }
}
