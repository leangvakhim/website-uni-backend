<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tse extends Model
{
    use HasFactory;

    protected $table = 'tbtse';
    protected $primaryKey = 'tse_id';

    protected $fillable = [
        'tse_sec',
        'tse_type',
        'tse_text',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'tse_sec', 'sec_id');
    }

    public function text()
    {
        return $this->belongsTo(Text::class, 'tse_text', 'text_id');
    }

    public function subtse()
    {
        return $this->hasMany(Subtse::class, 'stse_tse', 'tse_id');
    }
}
