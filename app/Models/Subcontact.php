<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcontact extends Model
{
    use HasFactory;
    protected $table = 'tbsubcontact';
    protected $primaryKey = 'scon_id';
    protected $fillable = [
        'scon_title', 'scon_detail', 'scon_img', 'scon_order', 'display', 'active'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'scon_img', 'image_id');
    }
    public function contact()
    {
        return $this->hasMany(Contact::class, 'con_addon', 'scon_id');
    }
}
