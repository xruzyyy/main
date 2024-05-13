<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\VisitorContact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class contactController extends Controller
{
    public function index()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        return view('pages.index', ['unseenCount' => $unseenCount]);
    }

    public function showContactForm()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        return view('pages.contact', ['unseenCount' => $unseenCount]);
    }

    public function submitContactForm(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'phone' => $request->phone

        ];
        Mail::to('cruzjerome012@gmail.com')->send(new VisitorContact($data));
        Session::flash('success', 'Your Email Was Successfully Sent. Thank You For Contacting Us!');
        return redirect()->route('contact.show');
    }
}
