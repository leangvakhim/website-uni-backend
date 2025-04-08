<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Academic extends Model
{
    use HasFactory;
    protected $table = 'tbacademic';
    protected $primaryKey = 'acad_id';
    protected $fillable = [
        'acad_sec', 'acad_title', 'acad_detail', 'acad_img',
        'acad_btntext1', 'acad_btntext2', 'acad_routepage', 'acad_routetext'
    ];

    public function section() {
        return $this->belongsTo(Section::class, 'acad_sec');
    }

    public function image() {
        return $this->belongsTo(Image::class, 'acad_img');
    }
}
