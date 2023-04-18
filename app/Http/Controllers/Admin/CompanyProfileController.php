<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CompanyProfileController extends Controller
{
    //
    public function index()
    {
        return view('admin.company_profile.company-profile');
    }
}
