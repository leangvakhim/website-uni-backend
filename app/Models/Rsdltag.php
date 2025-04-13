<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsdltag extends Model
{
    protected $table = 'tbrsdltag';
    protected $primaryKey = 'rsdlt';

    protected $fillable = [
        'rsdlt_rsdl',
        'rsdlt_title',
        'rsdlt_img',
        'active'
    ];

    public function rsdl()
    {
        return $this->belongsTo(Rsdl::class, 'rsdlt_rsdl', 'rsdl_id');
    }

    public function img()
    {
        return $this->belongsTo(Image::class, 'rsdlt_img', 'image_id');
    }
}