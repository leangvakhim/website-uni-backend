<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ha extends Model
{
    use HasFactory;
    protected $table = 'tbha';
    protected $primaryKey = 'ha_id';
    protected $fillable = ['ha_sec', 'ha_title', 'ha_img', 'ha_tagtitle', 'ha_subtitletag', 'ha_date'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'ha_sec', 'sec_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'ha_img', 'image_id');
    }
    public function subha()
    {
        return $this->hasMany(Subha::class, 'sha_ha', 'ha_id');
    }
}
