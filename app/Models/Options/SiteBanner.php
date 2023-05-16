<?php

namespace App\Models\Options;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteBanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'shortDesc',
        'image',
    ];
}
