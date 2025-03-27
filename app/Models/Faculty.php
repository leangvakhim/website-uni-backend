<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'tbfaculty';
    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'f_name',
        'f_position',
        'f_portfolio',
        'f_img',
        'f_social',
        'f_contact',
        'f_info',
        'f_bg',
        'f_order',
        'lang',
        'display',
        'active',
    ];
}
