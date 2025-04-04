<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'tbmenu';
    protected $primaryKey = 'menu_id';
    protected $fillable = [
        'title',
        'menu_order',
        'menup_id',
        'lang',
        'display',
        'active',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menup_id', 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'menup_id', 'menu_id');
    }
    public function pages()
    {
        return $this->hasMany(Page::class, 'p_menu', 'menu_id');
    }
}
