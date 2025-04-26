<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'tbcontact';
    protected $primaryKey = 'con_id';
    protected $fillable = ['con_title', 'con_subtitle', 'con_addon', 'lang', 'con_img', 'con_addon2', 'con_addon3'];

    public function subcontact1()
    {
        return $this->belongsTo(Subcontact::class, 'con_addon', 'scon_id');
    }

    public function subcontact2()
    {
        return $this->belongsTo(Subcontact::class, 'con_addon2', 'scon_id');
    }

    public function subcontact3()
    {
        return $this->belongsTo(Subcontact::class, 'con_addon3', 'scon_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'con_img', 'image_id');
    }
}
