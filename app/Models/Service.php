<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'tbservice';
    protected $primaryKey = 's_id';
    protected $fillable = [
        's_sec',
        's_title',
        's_subtitle',
        's_img',
        's_order',
        'display',
        'active'
    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 's_sec', 'sec_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 's_img', 'image_id');
    }
}
