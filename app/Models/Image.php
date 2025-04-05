<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'tbimage';
    protected $primaryKey = 'image_id';

    protected $fillable = [
        'img',
    ];

    public function slideshows()
    {
        return $this->hasMany(Slideshow::class, 'img', 'image_id');
    }

    public function logoSlideshows()
    {
        return $this->hasMany(Slideshow::class, 'logo', 'image_id');
    }

    public function socials()
    {
        return $this->hasMany(Social::class, 'social_img', 'image_id');
    }

    public function facultyBgs()
    {
        return $this->hasMany(FacultyBg::class, 'fbg_img', 'image_id');
    }

    public function facultyImgs()
    {
        return $this->hasMany(Faculty::class, 'f_img', 'image_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'n_img', 'image_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'e_img', 'image_id');
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class, 'sc_img', 'image_id');
    }

    public function letterScholarships()
    {
        return $this->hasMany(Scholarship::class, 'scletter_img', 'image_id');
    }

    public function rsd()
    {
        return $this->hasMany(Rsd::class, 'rsd_img', 'image_id');
    }

    public function rsdl()
    {
        return $this->hasMany(Rsdl::class, 'rsdl_img', 'image_id');
    }
    public function partnership()
    {
        return $this->hasMany(Partnership::class, 'ps_img', 'image_id');
    }

    public function umd()
    {
        return $this->hasMany(Umd::class, 'umd_img', 'image_id');
    }

    public function studyDegree()
    {
        return $this->hasMany(StudyDegree::class, 'std_img', 'image_id');
    }
    public function ha()
    {
        return $this->hasMany(Ha::class, 'ha_img', 'image_id');
    }
    public function intro()
    {
        return $this->hasMany(Intro::class, 'in_img', 'image_id');
    }
    public function fee()
    {
        return $this->hasMany(Fee::class, 'fe_img', 'image_id');
    }
    public function ufcsd()
    {
        return $this->hasMany(Ufcsd::class, 'uf_img', 'image_id');
    }
    public function service()
    {
        return $this->hasMany(Service::class, 's_img', 'image_id');
    }
}
