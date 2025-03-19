<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Button extends Model
{
    use HasFactory;

    protected $table = 'tbbutton';
    protected $primaryKey = 'button_id';

    protected $fillable = [
        'btn_title',
        'btn_url',
        'lang',
    ];

    public function slideshowsAsBtn1()
{
    return $this->hasMany(Slideshow::class, 'btn1', 'button_id');
}

public function slideshowsAsBtn2()
{
    return $this->hasMany(Slideshow::class, 'btn2', 'button_id');
}

}
