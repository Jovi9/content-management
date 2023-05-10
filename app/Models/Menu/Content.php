<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'main_menu_id',
        'sub_menu_id',
        'title',
        'content',
        'attachment',
        'status',
        'user_id',
        'mod_user_id',
        'isVisible',
        'isVisibleHome',
        'arrangement',
    ];
}
