<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Btnss extends Model
{
    use HasFactory;

    protected $table = 'tbbtnss';
    protected $primaryKey = 'bss_id';

    protected $fillable = [
        'bss_title',
        'bss_routepage',
        'display',
    ];
}
