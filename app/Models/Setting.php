<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'tbsetting';
    protected $primaryKey = 'set_id';
    protected $fillable =[
        'set_facultytitle',
        'set_facultydep',
        'set_logo',
        'set_social',
        'set_amstu',
        'set_enroll',
    ];

    public function logo()
    {
        return $this->belongsTo(Image::class, 'set_logo', 'image_id');
    }

    public function social()
    {
        return $this->belongsTo(Social::class, 'set_social', 'social_id');
    }
}
