<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subidd extends Model
{
    use HasFactory;
    protected $table = 'tbsubidd';
    protected $primaryKey = 'sidd_id';
    protected $fillable = [
        'sidd_idd',
        'sidd_sec',
        'sidd_title',
        'sidd_subtitle',
        'sidd_tag',
        'sidd_date',
        'sidd_order',
        'display',
        'active',
    ];

    public function idd()
    {
        return $this->belongsTo(Idd::class, 'sidd_idd', 'idd_id');
    }
}
