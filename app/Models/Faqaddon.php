<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faqaddon extends Model
{
    use HasFactory;
    protected $table = 'tbfaqaddon';
    protected $primaryKey = 'fa_id';
    protected $fillable = [
        'fa_faq',
        'fa_question',
        'fa_answer',
        'fa_order',
        'display',
        'active',
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class, 'fa_faq', 'faq_id');
    }
}
