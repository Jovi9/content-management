<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SubMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'main_menu_id',
        'subMenu',
        'subURI',
        'subLocation',
        'isEnabled',
    ];

    // protected static function booted()
    // {
    //     static::deleting(function (SubMenu $subMenu) {
    //         $subMenu->contents()->delete();
    //     });

    //     static::restoring(function (SubMenu $subMenu) {
    //         $subMenu->mainMenu()->restore();
    //         $subMenu->contents()->restore();
    //     });
    // }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function mainMenu(): HasOne
    {
        return $this->hasOne(MainMenu::class, 'id', 'main_menu_id');
    }
}
