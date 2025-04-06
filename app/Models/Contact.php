<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'tbcontact';
    protected $primaryKey = 'con_id';
    protected $fillable = ['con_title', 'con_subtitle', 'con_addon'];

    public function subcontact()
    {
        return $this->belongsTo(Subcontact::class, 'con_addon', 'scon_id');
    }
}
