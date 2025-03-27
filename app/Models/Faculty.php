<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'tbfaculty';
    protected $primaryKey = 'f_id';

    protected $fillable = [
        'f_name',
        'f_position',
        'f_portfolio',
        'f_img',
        'f_social',
        'f_contact',
        'f_info',
        'f_bg',
        'f_order',
        'lang',
        'display',
        'active',
    ];
    public function img()
    {
        return $this->belongsTo(Image::class, 'f_img', 'image_id');
    }
    
    public function social()
    {
        return $this->belongsTo(Social::class, 'f_social', 'social_id');
    }    

    public function contact()
{
    return $this->belongsTo(FacultyContact::class, 'f_contact', 'fc_id');
}

public function info()
{
    return $this->belongsTo(FacultyInfo::class, 'f_info', 'finfo_id');
}

public function bg()
{
    return $this->belongsTo(FacultyBg::class, 'f_bg', 'fbg_id');
}
}
