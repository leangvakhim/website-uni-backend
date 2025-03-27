<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtse extends Model
{
    use HasFactory;

    protected $table = 'tbsubtse';
    protected $primaryKey = 'stse_id';

    protected $fillable = [
        'stse_title',
        'stse_detail',
        'stse_order',
        'display',
        'active'
    ];
}
