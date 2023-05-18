<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName',
        'companyAddress',
        'companyHead',
        'companyHeadTitle',
        'companyType',
        'companyDescription',
        'email',
        'last_user_id',
        'companySub',
        'mainURI',
    ];
}
