<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gcaddon extends Model
{
    use HasFactory;

    protected $table = 'tbgcaddon';
    protected $primaryKey = 'gca_id';
    protected $fillable = [
        'gca_gc',
        'gca_tag',
        'gca_btntitle',
        'gca_btnlink',
       
    ];

    public function gc()
    {
        return $this->belongsTo(Gc::class, 'gca_gc');
    }
}
