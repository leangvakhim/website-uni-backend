<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'tbsubjects';
    protected $primaryKey = 'subject_id';
    protected $fillable = [
        'subject_name',
        'display',
        'active'
    ];
}
