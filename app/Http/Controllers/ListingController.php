<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Display the form for creating a new listing or store the listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a listing.');
        }

        // // Check if the user already has a listing
        // $existingListing = Category::where('user_id', auth()->user()->id)->first();

        // // If the user already has a listing, redirect back with an error message
        // if ($existingListing) {
        //     return redirect()->back()->with('error', 'You can only create one listing per user.');
        // }

        // If it's a POST request, handle form submission
        if ($request->isMethod('post')) {
            // Validate the request data
            $request->validate([
                'businessName' => 'required|max:255|string',
                'description' => 'required|max:255|string',
                'image' => 'required|mimes:jpg,jpeg,webp,png,jfif',
                'is_active' => 'sometimes' // Ensure is_active is allowed to be nullable
            ]);

            // Process the image upload
            $path = ''; // Define path variable
            if ($request->has('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $path = 'uploads/category/';
                $file->move($path, $filename);
            }

            // Create the category with the user_id set to the currently authenticated user's ID
            $category = Category::create([
                'businessName' => $request->businessName,
                'description' => $request->description,
                'image' => $path . $filename,
                'is_active' => $request->has('is_active') ? $request->input('is_active') : 1, // Set is_active based on user input or default to 1
                'user_id' => auth()->user()->id // Set the user_id to the ID of the currently authenticated user
            ]);

            // Dispatch the BusinessListingAdded event
            event(new \App\Events\BusinessListingAdded($category, $request->businessName, auth()->user()->id));

            // Check if the user's status is 0 and update the related category's is_active field to 0
            if ($request->has('is_active') && $request->input('is_active') == 0) {
                User::where('id', auth()->user()->id)
                    ->update(['status' => 0]); // Update user's status to 0

                Category::where('user_id', auth()->user()->id)
                    ->update(['is_active' => 0]); // Update related categories' is_active to 0
            }

            return redirect()->route('listings.create')->with('success', 'Listing created successfully!');
        }

        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Fetch the latitude and longitude values from the request (assuming they're passed via query string)
        $latitude = $request->query('latitude');
        $longitude = $request->query('longitude');

        // Pass the latitude and longitude values to the view
        return view('listings.create', compact('latitude', 'longitude', 'unseenCount'));
    }

    /**
     * Store a newly created listing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request)
    {
          // Check if the user already has a listing
    $existingListing = Category::where('user_id', auth()->user()->id)->first();

    // If the user already has a listing, redirect back with an error message
    if ($existingListing) {
        return redirect()->route('listings.create')->with('error', 'You can only create one listing per user.');
    }

        // Validate the request data
        $request->validate([
            'businessName' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'image' => 'required|mimes:jpg,jpeg,webp,png,jfif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'sometimes' // Ensure is_active is allowed to be nullable
        ]);

        // Process the image upload
        $path = ''; // Define path variable
        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/category/';
            $file->move($path, $filename);
        }

        // Create the category with the user_id set to the currently authenticated user's ID
        $category = Category::create([
            'businessName' => $request->businessName,
            'description' => $request->description,
            'image' => $path . $filename,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_active' => $request->has('is_active') ? $request->input('is_active') : 1, // Set is_active based on user input or default to 1
            'user_id' => auth()->user()->id // Set the user_id to the ID of the currently authenticated user
        ]);

        // Dispatch the BusinessListingAdded event
        event(new \App\Events\BusinessListingAdded($category, $request->businessName, auth()->user()->id));

        // Check if the user's status is 0 and update the related category's is_active field to 0
        if ($request->has('is_active') && $request->input('is_active') == 0) {
            User::where('id', auth()->user()->id)
                ->update(['status' => 0]); // Update user's status to 0

            Category::where('user_id', auth()->user()->id)
                ->update(['is_active' => 0]); // Update related categories' is_active to 0
        }

        return redirect()->route('listings.create')->with('success', 'Listing created successfully!');
    }

    // Display the map page
    public function map()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        return view('map', ['unseenCount' => $unseenCount]);
    }

    public function mapStore(Request $request)
{
    // Retrieve categories from the database
    $categories = Category::all(['id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass category data and any other necessary data to the view
    return view('mapStore', [
        'categories' => $categories,
    ]);
}


}
