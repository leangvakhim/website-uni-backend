<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsd extends Model
{
    use HasFactory;
    protected $table = 'tbrsd';
    protected $primaryKey = 'rsd_id';

    protected $fillable = [
        'rsd_title', 'rsd_subtitle', 'rsd_lead', 'rsd_img',
        'rsd_fav', 'lang', 'rsd_order', 'display', 'active',
        'ref_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'rsd_img', 'image_id')->select(['image_id', 'img']);
    }

    public function text()
    {
        return $this->belongsTo(RsdTitle::class, 'rsd_text', 'rsdt_id')->select(['rsdt_id', 'rsdt_title']);
    }
}