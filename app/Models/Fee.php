<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory;
    protected $table = 'tbfee';
    protected $primaryKey = 'fe_id';
    protected $fillable = [
        'fe_sec',
        'fe_title',
        'fe_desc',
        'fe_img',
        'fe_price',

    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'fe_sec', 'sec_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'fe_img', 'image_id');
    }
}
