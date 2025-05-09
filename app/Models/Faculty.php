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
        'f_order',
        'lang',
        'display',
        'active',
        'ref_id',
    ];
    public function img()
    {
        return $this->belongsTo(Image::class, 'f_img', 'image_id');
    }

    public function social()
    {
        return $this->belongsTo(Social::class, 'f_social', 'social_id');
    }

    public function contacts()
    {
        return $this->hasMany(FacultyContact::class, 'fc_f', 'f_id');
    }

    public function infos()
    {
        return $this->hasMany(FacultyInfo::class, 'finfo_f', 'f_id');
    }

    public function backgrounds()
    {
        return $this->hasMany(FacultyBg::class, 'fbg_f', 'f_id');
    }
    public function socials()
    {
        return $this->hasMany(Social::class, 'social_faculty', 'f_id');
    }
}
