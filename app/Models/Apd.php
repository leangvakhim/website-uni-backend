<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apd extends Model
{
    use HasFactory;

    protected $table = 'tbapd';
    protected $primaryKey = 'apd_id';
    protected $fillable = ['apd_title', 'apd_sec'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'apd_sec', 'sec_id');
    }

    public function subapd()
    {
        return $this->hasMany(Subapd::class, 'sapd_apd', 'apd_id');
    }
}
