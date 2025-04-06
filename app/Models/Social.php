<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Social extends Model
{
    use HasFactory;

    protected $table = 'tbsocial';
    protected $primaryKey = 'social_id';

    protected $fillable = [
        'social_img',
        'social_link',
        'social_order',
        'display',
        'active',
        'social_link',
        'social_faculty',
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'social_img', 'image_id');
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'social_faculty', 'f_id');
    }   
    public function setting()
    {
        return $this->hasMany(Setting::class, 'set_social', 'social_id');
    }


}
