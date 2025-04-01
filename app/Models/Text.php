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

}
