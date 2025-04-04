<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table = 'tbsection';
    protected $primaryKey = 'sec_id';

    protected $fillable = [
        'sec_page', 'sec_order', 'lang', 'display', 'active'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'sec_page', 'p_id');
    }

    public function slideshows()
    {
        return $this->hasMany(Slideshow2::class, 'slider_sec', 'sec_id');
    }

    public function headerSections()
    {
        return $this->hasMany(HeaderSection::class, 'hsec_sec', 'sec_id');
    }

    public function idds()
    {
        return $this->hasMany(Idd::class, 'idd_sec', 'sec_id');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_sec', 'sec_id');
    }

    public function apds()
    {
        return $this->hasMany(Apd::class, 'apd_sec', 'sec_id');
    }

    public function umds()
    {
        return $this->hasMany(Umd::class, 'umd_sec', 'sec_id');
    }
    
    public function studyDegrees()
    {
        return $this->hasMany(StudyDegree::class, 'std_sec', 'sec_id');
    }

    public function ha()
    {
        return $this->hasMany(Ha::class, 'ha_sec', 'sec_id');
    }

    public function intro()
    {
        return $this->hasMany(Intro::class, 'in_sec', 'sec_id');
    }
}
