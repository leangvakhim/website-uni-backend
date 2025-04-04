<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    protected $table = 'tbpage';
    protected $primaryKey = 'p_id';

    protected $fillable = [
        'p_menu',
        'p_title',
        'p_alias',
        'p_busy',
        'display',
        'active',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'p_menu', 'menu_id');
    }
}
