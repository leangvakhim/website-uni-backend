<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Button extends Model
{
    use hasFactory;

    protected $table = 'tbbutton';
    protected $primaryKey = 'button_id';

    protected $fillable = [
        'btn_title',
        'btn_url',
        'lang',
    ];
}
