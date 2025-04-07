<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subha extends Model
{
    use HasFactory;

    protected $table = 'tbsubha';
    protected $primaryKey = 'sha_id';

    protected $fillable = [
        'sha_ha',
        'sha_title',
        'sha_order',
        'display',
        'active',
    ];

    public function ha()
    {
        return $this->belongsTo(Ha::class, 'sha_ha', 'ha_id');
    }
}
