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
        'social_order',
        'display',
        'active',
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'social_img', 'image_id');
    }
}
