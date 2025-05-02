<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Career extends Model
{
    use HasFactory;
    protected $table = 'tbcareer';
    protected $primaryKey = 'c_id';
    protected $fillable = [
        'c_title',
        'c_shorttitle',
        'c_img',
        'c_date',
        'c_detail',
        'c_fav',
        'lang',
        'c_order',
        'display',
        'active'
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'c_img', 'image_id');
    }

}
