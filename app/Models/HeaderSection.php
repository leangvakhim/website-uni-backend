<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeaderSection extends Model
{
    use HasFactory;
    protected $table = 'tbheadersection';
    protected $primaryKey = 'hsec_id';
    protected $fillable = ['hsec_sec', 'hsec_title', 'hsec_subtitle', 'hsec_btntitle', 'hsec_routepage'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'hsec_sec', 'sec_id');
    }
}
