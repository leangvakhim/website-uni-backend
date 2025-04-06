<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ufcsd extends Model
{
    use HasFactory;
    protected $table = 'tbufcsd';
    protected $primaryKey = 'uf_id';
    protected $fillable = [
        'uf_sec',
        'uf_title',
        'uf_subtitle',
        'uf_img',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'uf_sec', 'sec_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'uf_img', 'image_id');
    }

    public function addons()
    {
        return $this->hasMany(Ufaddon::class, 'ufa_uf', 'uf_id');
    }
    
}
