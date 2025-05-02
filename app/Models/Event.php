<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'tbevent';
    protected $primaryKey = 'e_id';
    protected $fillable = [
        'e_title',
        'e_shorttitle',
        'e_img',
        'e_tags',
        'e_date',
        'e_detail',
        'e_fav',
        'lang',
        'e_order',
        'display',
        'active'
    ];
    public function img()
    {
        return $this->belongsTo(Image::class, 'e_img', 'image_id')->select(['image_id', 'img']);
    }
}
