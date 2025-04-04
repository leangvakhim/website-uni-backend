<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partnership extends Model
{
    use HasFactory; 
    protected $table = 'tbpartnership';
    protected $primaryKey = 'ps_id';
    public $timestamps = true;

    protected $fillable = [
        'ps_title',
        'ps_img',
        'ps_type',
        'ps_order',
        'active',
    ];
    
    public function img()
    {
        return $this->belongsTo(Image::class, 'ps_img', 'image_id');
    }
}
