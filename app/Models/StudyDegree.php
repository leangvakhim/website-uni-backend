<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyDegree extends Model
{
    use HasFactory;
    protected $table = 'tbstudydegree';
    protected $primaryKey = 'std_id';
    protected $fillable = [
        'std_sec', 'std_title', 'std_subtitle', 'std_type', 'display', 'active'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'std_sec', 'sec_id');
    }
}
