<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ashead extends Model
{
    use HasFactory;
    protected $table = 'tbashhead';
    protected $primaryKey = 'ash_id';
    protected $fillable = [
        'ash_title',
        'ash_subtitle',
        'ash_routetitle',
        'ash_routepage',
    ];
}
