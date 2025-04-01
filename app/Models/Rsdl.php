<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsdl extends Model
{
    use HasFactory;
    protected $table = 'tbrsdl';
    protected $primaryKey = 'rsdl_id';
    protected $fillable = [
        'rsdl_title',
        'rsdl_detail',
        'rsdl_fav',
        'lang',
        'rsdl_order',
        'display',
        'active'
    ];
}
