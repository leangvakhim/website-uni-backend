<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developersocial extends Model
{
    use HasFactory;
    protected $table = 'tbdevelopersocial';
    protected $primaryKey = 'ds_id';
    protected $fillable = [
        'ds_title',
        'ds_img',
        'ds_developer',
        'ds_link',
        'ds_order',
        'display',
        'active'
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'ds_developer', 'd_id');
    }

    public function img()
    {
        return $this->belongsTo(Image::class, 'ds_img', 'image_id');
    }
}
