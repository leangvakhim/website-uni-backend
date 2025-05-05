<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;
    protected $table = 'tbannouncement';
    protected $primaryKey = 'am_id';
    protected $fillable = [
        'am_title',
        'am_shortdesc',
        'am_detail',
        'am_postdate',
        'am_img',
        'am_fav',
        'lang',
        'am_orders',
        'display',
        'active',
        'ref_id'
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'am_img', 'image_id');
    }
}