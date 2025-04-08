<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slideshow2 extends Model
{
    use HasFactory;

    protected $table = 'tbslideshow2';
    protected $primaryKey = 'slider_id';

    protected $fillable = [
        'slider_title',
        'slider_text',
        'btn1',
        'btn2',
        'img',
        'logo',
        'slider_order',
        'display',
        'active',
        'slider_sec',
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'img', 'image_id')->select(['image_id', 'img']);
    }

    public function logo()
    {
        return $this->belongsTo(Image::class, 'logo', 'image_id')->select(['image_id', 'img']);
    }

    public function btn1()
    {
        return $this->belongsTo(Btnss::class, 'btn1', 'bss_id')->select(['bss_id', 'bss_title', 'bss_routepage', 'display']);
    }

    public function btn2()
    {
        return $this->belongsTo(Btnss::class, 'btn2', 'bss_id')->select(['bss_id', 'bss_title', 'bss_routepage', 'display']);
    }

    public function slider_sec()
    {
        return $this->belongsTo(Section::class, 'slider_sec', 'sec_id')->select(['sec_id', 'sec_title']);
    }
}
