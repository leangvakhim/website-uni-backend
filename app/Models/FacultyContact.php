<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacultyContact extends Model
{
    use HasFactory;

    protected $table = 'tbfaculty_contact';
    protected $primaryKey = 'fc_id';

    protected $fillable = [
        'fc_name',
        'fc_order',
        'display',
        'active',
        'fc_f',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'fc_f', 'f_id');
    }
}
