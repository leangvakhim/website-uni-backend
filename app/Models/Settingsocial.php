<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settingsocial extends Model
{
    use HasFactory;
    protected $table = 'tbsettingsocial';
    protected $primaryKey = 'setsoc_id';
    protected $fillable = [
        'setsoc_title',
        'setsoc_img',
        'setsoc_setting',
        'setsoc_link',
        'setsoc_order',
        'display',
        'active'
    ];
    public function setting()
    {
        return $this->belongsTo(Setting2::class, 'setsoc_setting', 'set_id');
    }

    public function img()
    {
        return $this->belongsTo(Image::class, 'setsoc_img', 'image_id');
    }
}
