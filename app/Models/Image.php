<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'tbimage';
    protected $primaryKey = 'image_id';

    protected $fillable = [
        'img',
    ];
}
