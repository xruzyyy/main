<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ListingController extends Controller
{
    /**
     * Display the form for creating a new listing.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created listing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // Store a newly created listing in storage.
    public function store(Request $request)
    {
        $request->validate([
            'businessName' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'image' => 'required|mimes:jpg,jpeg,webp,png,jfif',
            'is_active' => 'sometimes' // Ensure is_active is allowed to be nullable
        ]);
    
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
    

}

