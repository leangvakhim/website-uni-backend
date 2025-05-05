<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $table = 'tbnew';
    protected $primaryKey = 'n_id';
    protected $fillable = [
        'n_title',
        'n_shorttitle',
        'n_img',
        'n_tags',
        'n_date',
        'n_detail',
        'n_fav',
        'lang',
        'n_order',
        'display',
        'active',
        'ref_id'
    ];
    public function img()
    {
        return $this->belongsTo(Image::class, 'n_img', 'image_id')->select(['image_id', 'img']);
    }
}
