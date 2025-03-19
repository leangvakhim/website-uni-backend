<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = 'tbslideshow';
    protected $primaryKey = 'slider_id';

    protected $fillable = [
        'slider_text',
        'btn1',
        'btn2',
        'img',
        'logo',
        'slider_order',
        'display',
        'active',
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
        return $this->belongsTo(Button::class, 'btn1', 'button_id')->select(['button_id', 'btn_title', 'btn_url']);
    }

    public function btn2()
    {
        return $this->belongsTo(Button::class, 'btn2', 'button_id')->select(['button_id', 'btn_title', 'btn_url']);
    }

    public function slider_text()
    {
        return $this->belongsTo(Text::class, 'slider_text', 'text_id')->select(['text_id', 'title', 'desc', 'tag', 'lang']);
    }
}
