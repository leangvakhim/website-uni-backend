<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ras extends Model
{
    use HasFactory;
    protected $table = 'tbras';
    protected $primaryKey = 'ras_id';
    protected $fillable = ['ras_sec', 'ras_text', 'ras_img1', 'ras_img2'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'ras_sec');
    }

    public function text()
    {
        return $this->belongsTo(Text::class, 'ras_text');
    }

    public function image1()
    {
        return $this->belongsTo(Image::class, 'ras_img1');
    }

    public function image2()
    {
        return $this->belongsTo(Image::class, 'ras_img2');
    }

    public function rasons()
    {
        return $this->hasMany(Rason::class, 'rason_ras');
    }
}
