<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Text extends Model
{
    use HasFactory;

    protected $table = 'tbtext';
    protected $primaryKey = 'text_id';

    protected $fillable = [
        'title',
        'desc',
        'text_type',
        'tag',
        'lang',
    ];

    public function slideshows()
{
    return $this->hasMany(Slideshow::class, 'slider_text', 'text_id');
}

public function acadfaculties()
{
    return $this->hasMany(AcadFacility::class, 'af_text', 'text_id');
}

public function tse()
{
    return $this->hasMany(Tse::class, 'tse_text', 'text_id');

}

public function ras()
{
    return $this->hasMany(Ras::class, 'ras_text', 'text_id');
}

}
