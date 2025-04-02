<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RsdTitle extends Model
{
    use HasFactory;

    protected $table = 'tbrsd_title';
    protected $primaryKey = 'rsdt_id';

    protected $fillable = [
        'rsdt_title',
        'rsdt_order',
        'display',
        'active',
    ];
}
