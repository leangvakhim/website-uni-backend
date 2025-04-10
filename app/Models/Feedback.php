<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'tbfeedback';
    protected $primaryKey = 'fb_id';

    protected $fillable = [
       // 'fb_sec', 
        'fb_title', 'fb_subtitle', 'fb_writer',
        'fb_img', 'fb_order', 'lang', 'display', 'active'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'fb_sec', 'sec_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'fb_img', 'image_id');
    }
}
