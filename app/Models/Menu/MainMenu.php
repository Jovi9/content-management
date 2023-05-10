<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mainMenu',
        'mainURI',
        'mainLocation',
        'isEnabled'
    ];

    protected static function booted()
    {
        static::deleting(function (MainMenu $mainMenu) {
            $mainMenu->subMenus()->delete();
            $mainMenu->contents()->delete();
        });

        static::restoring(function (MainMenu $mainMenu) {
            $mainMenu->contents()->restore();
            $mainMenu->subMenus()->restore();
        });
    }

    public function subMenus(): HasMany
    {
        return $this->hasMany(SubMenu::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
