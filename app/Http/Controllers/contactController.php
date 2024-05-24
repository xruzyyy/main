<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\VisitorContact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;

class contactController extends Controller
{
    // Method to display all business posts
    public function index()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Fetch latest business posts
        $latestPosts = Posts::orderBy('created_at', 'desc')->get();

        // Pass the posts data to the view
        return view('business-section.postsFeatured', [
            'unseenCount' => $unseenCount,
            'latestPosts' => $latestPosts
        ]);
    }

    // Method to display a specific business post
    public function show($id)
    {
        // Fetch the business post by ID
        $post = Posts::findOrFail($id);

        // Pass the post data to the view
        return view('business-section.postsFeatured', ['post' => $post]);
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
