<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacultyInfo extends Model
{
    use HasFactory;

    protected $table = 'tbfaculty_info';
    protected $primaryKey = 'finfo_id';

    protected $fillable = [
        'finfo_title',
        'finfo_detail',
        'finfo_side',
        'finfo_order',
        'display',
        'active',
        'finfo_f',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'finfo_f', 'f_id');
    }
}
