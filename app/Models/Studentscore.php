<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Studentscore extends Model
{
    use HasFactory;
    protected $table = 'tbstudentscore';
    protected $primaryKey = 'score_id';
    protected $fillable = [
        'student_id',
        'subject_id',
        'score',
        'display',
        'active'        
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }
}
