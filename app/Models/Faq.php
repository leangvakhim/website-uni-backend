<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'tbfaq';
    protected $primaryKey = 'faq_id';
    protected $fillable = ['faq_sec', 'faq_title', 'faq_subtitle'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'faq_sec', 'sec_id');
    }

    public function addons()
    {
        return $this->hasMany(Faqaddon::class, 'fa_faq', 'faq_id');
    }
}
