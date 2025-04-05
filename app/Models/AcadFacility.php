<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcadFacility extends Model
{
    use HasFactory;

    protected $table = 'tbacadfacility';
    protected $primaryKey = 'af_id';

    protected $fillable = [
        'af_sec',
        'af_text',
        'af_img',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'af_sec', 'sec_id');
    }

    public function text()
    {
        return $this->belongsTo(Text::class, 'af_text', 'text_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'af_img', 'image_id');
    }
}
