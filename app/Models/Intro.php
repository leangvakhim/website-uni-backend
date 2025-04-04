<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intro extends Model
{
    use HasFactory;
    protected $table = 'tbintro';
    protected $primaryKey = 'in_id';
    protected $fillable = [
        'in_sec',
        'in_title',
        'in_detail',
        'in_img',
        'inadd_title',
        'in_addsubtitle',

    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'intro_sec', 'sec_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'intro_img', 'image_id');
    }
}
