<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Public\ContactUsRequest;
use App\Mail\ContactUs;
use App\Models\CompanyProfile;
use App\Models\Public\Mail as PublicMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContacUsController extends Controller
{
    public function sendEmail(ContactUsRequest $request)
    {
        //
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->message,
        ];

        $companyProfile = CompanyProfile::first();

        if (!($companyProfile)) {
            return Redirect::route('public-about')->with('no-email', 'success');
        } else {
            Mail::to($companyProfile->email)->send(new ContactUs($data));

            PublicMail::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            return Redirect::route('public-about')->with('mail-sent', 'success');
        }
    }
}
