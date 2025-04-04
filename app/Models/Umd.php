<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Umd extends Model
{
    use HasFactory;
    protected $table = 'tbumd';
    protected $primaryKey = 'umd_id';
    protected $fillable = [
        'umd_sec', 'umd_title', 'umd_detail', 'umd_routepage', 'umd_btntext',
        'umd_img', 'display', 'active'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'umd_sec', 'sec_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'umd_img', 'image_id');
    }
}
