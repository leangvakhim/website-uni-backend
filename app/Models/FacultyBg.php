<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Image;

class FacultyBg extends Model
{
    use HasFactory;

    protected $table = 'tbfaculty_bg';
    protected $primaryKey = 'fbg_id';

    protected $fillable = [
        'fbg_name',
        'fbg_img',
        'fbg_order',
        'display',
        'active',
        'fbg_f',
    ];

    public function img()
    {
        return $this->belongsTo(Image::class, 'fbg_img', 'image_id');
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'fbg_f', 'f_id');
    }
}
