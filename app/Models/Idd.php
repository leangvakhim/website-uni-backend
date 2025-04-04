<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idd extends Model
{
    use HasFactory;

    protected $table = 'tbidd';
    protected $primaryKey = 'idd_id';
    protected $fillable = ['idd_sec', 'idd_title', 'idd_subtitle'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'idd_sec', 'sec_id');
    }
}
