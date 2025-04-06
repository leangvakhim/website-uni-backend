<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gc extends Model
{
    use HasFactory;
    protected $table = 'tbgc';
    protected $primaryKey = 'gc_id';

    protected $fillable = [
        'gc_sec', 'gc_title', 'gc_tag', 'gc_type', 'gc_detail',
        'gc_img1', 'gc_img2'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'gc_sec');
    }

    public function image1()
    {
        return $this->belongsTo(Image::class, 'gc_img1');
    }

    public function image2()
    {
        return $this->belongsTo(Image::class, 'gc_img2');
    }
}
