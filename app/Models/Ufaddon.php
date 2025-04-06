<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ufaddon extends Model
{
    use HasFactory;
    protected $table = 'tbufaddon';
    protected $primaryKey = 'ufa_id';

    protected $fillable = [
        'ufa_uf',
        'ufa_title',
        'ufa_subtitle',
        'ufa_order',
        'display',
        'active',
    ];

    public function uf()
    {
        return $this->belongsTo(Ufcsd::class, 'ufa_uf', 'uf_id');
    }
}
