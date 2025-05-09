<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RsdMeet extends Model
{
    use HasFactory;
    protected $table = 'tbrsd_meet';
    protected $primaryKey = 'rsdm_id';
    protected $fillable = [
        'rsdm_detail',
        'rsdm_title',
        'rsdm_img',
        'rsdm_rsdtitle',
        'rsdm_faculty',
        'active',

    ];
    public function img()
    {
        return $this->belongsTo(Image::class, 'rsdm_img', 'image_id')->select(['image_id', 'img']);
    }

    public function faculty()
    {
        return $this->belongsTo(FacultyContact::class, 'rsdm_faculty', 'fc_id')->select(['fc_id', 'fc_name']);
    }

    public function title()
    {
        return $this->belongsTo(RsdTitle::class, 'rsdm_rsdtitle', 'rsdt_id')->select(['rsdt_id', 'rsdt_text']);
    }
}
