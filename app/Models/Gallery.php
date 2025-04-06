<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'tbgallery';
    protected $primaryKey = 'gal_id';
    public $timestamps = true;

    protected $fillable = [
        'gal_sec',
        'gal_text',
        'gal_img1',
        'gal_img2',
        'gal_img3',
        'gal_img4',
        'gal_img5',
    ];

    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class, 'gal_sec');
    }

    public function text()
    {
        return $this->belongsTo(\App\Models\Text::class, 'gal_text');
    }

    public function image1()
    {
        return $this->belongsTo(\App\Models\Image::class, 'gal_img1');
    }

    public function image2()
    {
        return $this->belongsTo(\App\Models\Image::class, 'gal_img2');
    }

    public function image3()
    {
        return $this->belongsTo(\App\Models\Image::class, 'gal_img3');
    }

    public function image4()
    {
        return $this->belongsTo(\App\Models\Image::class, 'gal_img4');
    }

    public function image5()
    {
        return $this->belongsTo(\App\Models\Image::class, 'gal_img5');
    }
}
