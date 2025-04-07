<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subservice extends Model
{
    use HasFactory;
    protected $table = 'tbsubservice';
    protected $primaryKey = 'ss_id';
    protected $fillable = [
        'ss_af',
        'ss_ras',
        'ss_title',
        'ss_subtitle',
        'ss_img',
        'ss_order',
        'display',
        'active',
    ];
    public function ras()
    {
        return $this->belongsTo(Ras::class, 'ss_ras');
    }

    public function af()
    {
        return $this->belongsTo(Acadfacility::class, 'ss_af');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'ss_img');
    }
}
