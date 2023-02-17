<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CompanyProfileRequest;
use App\Http\Controllers\UserLogActivityController;

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
        $query = CompanyProfile::create([
            'companyName' => $request->companyName,
            'companyAddress' => $request->companyAddress,
            'companyHead' => $request->companyHead,
            'companyHeadTitle' => $request->companyHeadTitle,
            'companyType' => $request->companyType,
            'companyDescription' => $request->companyDescription
        ]);

        $log = [];
        $log['action'] = "Created Company Profile";
        $log['content'] = "Company Name: " . $request->companyName . ", Company Address: " . $request->companyAddress . ", Company Head: "  . $request->companyHead . ", Company Head Title: "  . $request->companyHeadTitle . ", Company Type: " . $request->companyType . ", Company Description: " . $request->companyDescription;
        $log['changes'] = '';

        if ($query) {
            UserLogActivityController::store($log);
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
        $companyProfile = CompanyProfile::where('id', $id)->first();
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

        $log = [];
        $log['action'] = "Updated Company Profile";
        $log['content'] = "Company Name: " . $companyProfile->companyName . ", Company Address: " . $companyProfile->companyAddress . ", Company Head: "  . $companyProfile->companyHead . ", Company Head Title: "  . $companyProfile->companyHeadTitle . ", Company Type: " . $companyProfile->companyType . ", Company Description: " . $companyProfile->companyDescription;
        $log['changes'] = "Company Name: " . $request->companyName . ", Company Address: " . $request->companyAddress . ", Company Head: "  . $request->companyHead . ", Company Head Title: "  . $request->companyHeadTitle . ", Company Type: " . $request->companyType . ", Company Description: " . $request->companyDescription;

        if ($query) {
            UserLogActivityController::store($log);
            return Redirect::route('admin.company_profile.index')->with('status', 'company-profile-updated');
        } else {
            return back();
        }
    }
}
