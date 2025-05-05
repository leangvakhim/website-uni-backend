<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;
    protected $table = 'tbemail';
    protected $primaryKey = 'm_id';
    protected $fillable = [
        'm_firstname',
        'm_lastname',
        'm_email',
        'm_description',
        'm_active'
    ];
}
