<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subapd extends Model
{
    use HasFactory;

    protected $table = 'tbsubapd';
    protected $primaryKey = 'sapd_id';
    protected $fillable = [
        'sapd_apd', 'sapd_title', 'sapd_img', 'sapd_routepage',
        'sapd_order', 'display', 'active'
    ];

    public function apd()
    {
        return $this->belongsTo(Apd::class, 'sapd_apd');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'sapd_img');
    }


}
