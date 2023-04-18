<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_menu_id',
        'subMenu',
        'subURI',
        'subLocation',
        'isEnabled',
    ];
}
