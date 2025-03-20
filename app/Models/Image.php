<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'tbimage';
    protected $primaryKey = 'image_id';

    protected $fillable = [
        'img',
    ];

    public function slideshows()
    {
        return $this->hasMany(Slideshow::class, 'img', 'image_id');
    }

    public function logoSlideshows()
    {
        return $this->hasMany(Slideshow::class, 'logo', 'image_id');
    }

    public function socials()
    {
        return $this->hasMany(Social::class, 'social_img', 'image_id');
    }
}
