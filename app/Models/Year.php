<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $table = 'tbyear';
    protected $primaryKey = 'y_id';

    protected $fillable = [
        'y_title',
        'y_subtitle',
        'y_detail',
        'y_order',
        'display',
        'active',
    ];
}
