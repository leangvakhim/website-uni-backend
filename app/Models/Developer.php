<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;
    protected $table = 'tbdeveloper';
    protected $primaryKey = 'd_id';
    protected $fillable = [
        'd_name',
        'd_position',
        'd_write',
        'd_img',
        'lang',
        'd_order',
        'display',
        'active'
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'd_img', 'image_id');
    }
}
