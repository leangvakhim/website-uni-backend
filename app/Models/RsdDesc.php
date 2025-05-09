<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RsdDesc extends Model
{
    use HasFactory;

    protected $table = 'tbrsd_desc';
    protected $primaryKey = 'rsdd_id';

    protected $fillable = [
        'rsdd_rsdtile',
        'rsdd_details',
        'active',
        'rsdd_title'
    ];

    public function title()
    {
        return $this->belongsTo(RsdTitle::class, 'rsdd_rsdtile', 'rsdt_id')->select(['rsdt_id', 'rsdt_text']);
    }
}
