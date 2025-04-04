<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table = 'tbsection';
    protected $primaryKey = 'sec_id';

    protected $fillable = [
        'sec_page', 'sec_order', 'lang', 'display', 'active'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'sec_page', 'p_id');
    }
}
