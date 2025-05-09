<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $table = 'tbstudents';
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'result',
        'student_identity',
        'display',
        'active'
    ];
}
