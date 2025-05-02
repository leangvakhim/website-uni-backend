<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsdl extends Model
{
    use HasFactory;
    protected $table = 'tbrsdl';
    protected $primaryKey = 'rsdl_id';
    protected $fillable = [
        'rsdl_title',
        'rsdl_detail',
        'rsdl_fav',
        'lang',
        'rsdl_order',
        'display',
        'active',
        'rsdl_img',
    ];

    public function rsdltag()
    {
        return $this->hasMany(Rsdltag::class, 'rsdlt_rsdl', 'rsdl_id')->select(['rsdlt', 'rsdlt_title', 'rsdlt_img']);
    }

    public function img()
    {
        return $this->belongsTo(Image::class, 'rsdl_img', 'image_id');
    }


}
