<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $table = 'tbdepartment';
    protected $primaryKey = 'dep_id';
    public $timestamps = true;

    protected $fillable = [
        'dep_sec', 'dep_title', 'dep_detail', 'dep_img1', 'dep_img2'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'dep_sec', 'sec_id');
    }

    public function image1()
    {
        return $this->belongsTo(Image::class, 'dep_img1', 'image_id');
    }

    public function image2()
    {
        return $this->belongsTo(Image::class, 'dep_img2', 'image_id');
    }
}
