<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'tbtestimonial';
    protected $primaryKey = 't_id';

    protected $fillable = [
        't_title',
        't_sec',

    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 't_sec', 'sec_id');
    }
}
