<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scholarship extends Model
{
    use HasFactory;
    protected $table = 'tbscholarship';
    protected $primaryKey = 'sc_id';
    protected $fillable = [
        'sc_sponsor',
        'sc_title',
        'sc_shortdesc',
        'sc_detail',
        'sc_deadline',
        'sc_postdate',
        'sc_img',
        'scletter_img',
        'sc_fav',
        'lang',
        'sc_orders',
        'display',
        'active',
        'ref_id'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'sc_img', 'image_id')->select(['image_id', 'img']);
    }

    public function letter()
    {
        return $this->belongsTo(Image::class, 'scletter_img', 'image_id')->select(['image_id', 'img']);
    }
}
