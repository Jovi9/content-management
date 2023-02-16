<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CompanyProfileRequest;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = CompanyProfile::count();
        $profile = CompanyProfile::get()->first();
        return view('admin.company_profile.company', [
            'count' => $count,
            'profile' => $profile
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyProfileRequest $request)
    {
        // dd($request);
        $query = CompanyProfile::create([
            'companyName' => $request->companyName,
            'companyAddress' => $request->companyAddress,
            'companyHead' => $request->companyHead,
            'companyHeadTitle' => $request->companyHeadTitle,
            'companyType' => $request->companyType,
            'companyDescription' => $request->companyDescription
        ]);

        if ($query) {
            return Redirect::route('admin.company_profile.index')->with('status', 'company-profile-saved');
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $count = CompanyProfile::count();
        if ($count == 0) {
            return back();
        } else {
            $profile = CompanyProfile::get()->first();
            return view('admin.company_profile.edit', [
                'profile' => $profile
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyProfileRequest $request, $id)
    {
        // dd($request);
        $query = CompanyProfile::where('id', $id)
            ->update([
                'companyName' => $request->companyName,
                'companyAddress' => $request->companyAddress,
                'companyHead' => $request->companyHead,
                'companyHeadTitle' => $request->companyHeadTitle,
                'companyType' => $request->companyType,
                'companyDescription' => $request->companyDescription
            ]);

        if ($query) {
            return Redirect::route('admin.company_profile.index')->with('status', 'company-profile-updated');
        } else {
            return back();
        }
    }
}
