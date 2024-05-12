<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
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

        // If it's a POST request, handle form submission
        if ($request->isMethod('post')) {
            // Validate the request data
            $request->validate([
                'businessName' => 'required|max:255|string',
                'description' => 'required|max:200|string',
                'images.*' => 'required|mimes:jpg,jpeg,webp,png,jfif|max:2048', // Adjusted validation rule for multiple images
                'type' => 'required', // Validate the type field
                'contactNumber' => 'required|numeric|digits:11', // Ensure contact number is required, numeric, and exactly 11 digits long
                'is_active' => 'sometimes', // Ensure is_active is allowed to be nullable
            ]);

            // Process the images uploads
            $paths = []; // Define an array to store paths of uploaded images
            if ($request->has('images')) {
                foreach ($request->file('images') as $images) {
                    $extension = $images->getClientOriginalExtension();
                    $filename = time() . '_' . uniqid() . '.' . $extension;
                    $path = 'uploads/category/';
                    $images->move($path, $filename);
                    $paths[] = $path . $filename; // Store the path of each uploaded images
                }
            }
          
            // Create the category with the user_id set to the currently authenticated user's ID
            $posts = Posts::create([
                'businessName' => $request->businessName,
                'description' => $request->description,
                'images' => json_encode($paths), // Store paths as JSON string
                'contactNumber' => $request->contactNumber,
                'is_active' => $request->has('is_active') ? $request->input('is_active') : 1,
                'type' => $request->type,
                'user_id' => auth()->user()->id
            ]);

            // Dispatch the BusinessListingAdded event
            event(new \App\Events\BusinessListingAdded($posts, $request->businessName, auth()->user()->id));

            // Check if the user's status is 0 and update the related category's is_active field to 0
            if ($request->has('is_active') && $request->input('is_active') == 0) {
                User::where('id', auth()->user()->id)
                    ->update(['status' => 0]); // Update user's status to 0

                Posts::where('user_id', auth()->user()->id)
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
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'businessName' => 'required|max:255|string',
            'description' => 'required|max:200|string',
            'images.*' => 'required|mimes:jpg,jpeg,webp,png,jfif|max:2048', // Adjusted validation rule for multiple images
            'type' => 'required', // Validate the type field
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contactNumber' => 'required', // Validate the contactNumber field
            'is_active' => 'sometimes', // Ensure is_active is allowed to be nullable
        ]);
    
        // Process the images uploads
        $paths = []; // Define an array to store paths of uploaded images
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $path = 'uploads/category/';
                $image->move($path, $filename);
                $paths[] = $path . $filename; // Store the path of each uploaded image
            }
        }
    
        // Store the image paths as a JSON string
        $imagesJson = json_encode($paths);
    
        // Create the category with the user_id set to the currently authenticated user's ID
        $post = Posts::create([
            'businessName' => $request->businessName,
            'description' => $request->description,
            'images' => $imagesJson,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'contactNumber' => $request->contactNumber,
            'is_active' => $request->has('is_active') ? $request->input('is_active') : 1,
            'type' => $request->type,
            'user_id' => auth()->user()->id
        ]);
    
        // Dispatch the BusinessListingAdded event
        event(new \App\Events\BusinessListingAdded($post, $request->businessName, auth()->user()->id));
    
        // Check if the user's status is 0 and update the related category's is_active field to 0
        if ($request->has('is_active') && $request->input('is_active') == 0) {
            User::where('id', auth()->user()->id)
                ->update(['status' => 0]); // Update user's status to c
    
            Posts::where('user_id', auth()->user()->id)
                ->update(['is_active' => 0]); // Update related categories' is_active to 0
        }
    
        return redirect()->route('listings.create')->with('success', 'Listing created successfully!');
    }
    

    // Display the map page
    public function createForm()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        return view('listings.createForm', ['unseenCount' => $unseenCount]);
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
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Retrieve categories from the database
        $posts = Posts::all(['id', 'businessName', 'description', 'images', 'latitude', 'longitude', 'is_active']);

        // Pass category data and any other necessary data to the view
        return view('mapStore', [
            'posts' => $posts, // Use 'posts' instead of 'categories' as the variable name
            'unseenCount' => $unseenCount,
        ]);
    }
}
