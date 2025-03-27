<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rason extends Model
{
    use HasFactory;

    protected $table = 'tbrason';
    protected $primaryKey = 'rason_id';

    protected $fillable = [
        'rason_title',
        'rason_amount',
        'rason_subtitle'
    ];
}
