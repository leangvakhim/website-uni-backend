<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'tbbanner';
    protected $primaryKey = 'ban_id';

    protected $fillable = [
        'ban_title',
        'ban_subtitle',
        'ban_sec',
        'ban_img',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'ban_sec', 'sec_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'ban_img', 'image_id');
    }
}
