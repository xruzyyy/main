<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CommentController;

class ManagePostController extends Controller
{


    /**
     * Display the specified business post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Posts::findOrFail($id);
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();
        return view('business_post', compact('post', 'comments'));
    }

    /**
     * Store a newly created comment for the specified business post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function index()
{
    // Fetch unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    // Fetch all ManagePost with their associated users
    $ManagePost = Posts::with('user')->get();

    // Pass both variables to the view
    return view('category.index', compact('ManagePost', 'unseenCount'));
}

 // Display the map page
 public function mapAdmin()
 {
     // Fetch unseen message count
     $unseenCount = DB::table('ch_messages')
         ->where('to_id', '=', Auth::user()->id)
         ->where('seen', '=', '0')
         ->count();

     return view('mapAdmin', ['unseenCount' => $unseenCount]);
 }

// public function create()
// {
//     // Fetch unseen message count
//     $unseenCount = DB::table('ch_messages')
//         ->where('to_id', '=', Auth::user()->id)
//         ->where('seen', '=', '0')
//         ->count();

//     return view('category.create', compact('unseenCount'));
// }


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
            'description' => 'required|max:255|string',
            'images.*' => 'required|mimes:jpg,jpeg,webp,png,jfif|max:2048', // Adjusted validation rule for multiple images
            'type' => 'required', // Validate the type field
            'contactNumber' => 'required|numeric|digits:11', // Ensure contact number is required, numeric, and exactly 11 digits long
            'is_active' => 'sometimes', // Ensure is_active is allowed to be nullable
        ]);

        // Process the image upload
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
            'contactNumber' => $request->contactNumber, // Set the contactNumber field
            'is_active' => $request->has('is_active') ? $request->input('is_active') : 1, // Set is_active based on user input or default to 1
            'type' => $request->type, // Set the type field
            'user_id' => auth()->user()->id, // Set the user_id to the ID of the currently authenticated user
        ]);

        // Dispatch the BusinessListingAdded event
        event(new \App\Events\BusinessListingAdded($posts, $request->businessName, auth()->user()->id));

        // Check if the user's status is 0 and update the related category's is_active field to 0
        if ($request->has('is_active') && $request->input('is_active') == 0) {
            User::where('id', auth()->user()->id)
                ->update(['status' => 0]); // Update user's status to 0

            Posts::where('user_id', auth()->user()->id)
                ->update(['is_active' => 0]); // Update related ManagePost' is_active to 0
        }

        return redirect()->route('managepost.create')->with('success', 'Listing created successfully!');
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
    return view('category.create', compact('latitude', 'longitude', 'unseenCount'));
}


// Store a newly created listing in storage.
protected function store(Request $request)
{

    // Validate the request data
    $request->validate([
        'businessName' => 'required|max:255|string',
        'description' => 'required|max:255|string',
        'images.*' => 'required|mimes:jpg,jpeg,webp,png,jfif|max:2048', // Adjusted validation rule for multiple images
        'type' => 'required', // Validate the type field
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'contactNumber' => 'required', // Validate the contactNumber field
        'is_active' => 'sometimes', // Ensure is_active is allowed to be nullable
    ]);

    // Process the image upload
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
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'contactNumber' => $request->contactNumber, // Set the contactNumber field
        'is_active' => $request->has('is_active') ? $request->input('is_active') : 1, // Set is_active based on user input or default to 1
        'type' => $request->type, // Set the type field
        'user_id' => auth()->user()->id // Set the user_id to the ID of the currently authenticated user
    ]);

    // Dispatch the BusinessListingAdded event
    event(new \App\Events\BusinessListingAdded($posts, $request->businessName, auth()->user()->id));

    // Check if the user's status is 0 and update the related posts's is_active field to 0
    if ($request->has('is_active') && $request->input('is_active') == 0) {
        User::where('id', auth()->user()->id)
            ->update(['status' => 0]); // Update user's status to c

        Posts::where('user_id', auth()->user()->id)
            ->update(['is_active' => 0]); // Update related ManagePost' is_active to 0
    }

    return redirect()->route('managepost.create')->with('success', 'Listing created successfully!');
}


public function edit(int $id)
    {
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', Auth::user()->id)
            ->where('seen', '0')
            ->count();

        $posts = Posts::findOrFail($id);

        return view('category.edit', compact('posts', 'unseenCount'));
    }

    public function update(Request $request, $id)
{
    // Retrieve the post
    $post = Posts::findOrFail($id);

    // Validate the request data
    $request->validate([
        'businessName' => 'required|max:255|string',
        'description' => 'required|max:255|string',
        'images.*' => 'required|mimes:jpg,jpeg,webp,png,jfif|max:2048', // Adjusted validation rule for multiple images
        'is_active' => 'sometimes', // Ensure is_active is allowed to be nullable
    ]);

    // Process the image upload
    $paths = []; // Define an array to store paths of uploaded images
    if ($request->has('images')) {
        foreach ($request->file('images') as $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $path = 'uploads/category/';
            $image->move($path, $filename);
            $paths[] = $path . $filename; // Store the path of each uploaded image
        }
        // Replace existing images with new ones
        $post->images = json_encode($paths);
    }

    // Update the post attributes
    $post->businessName = $request->input('businessName');
    $post->description = $request->input('description');
    $post->is_active = $request->has('is_active');

    // Save the changes
    $post->save();

    // Redirect back with a success message
    return redirect()->route('ManagePost')->with('status', 'Post updated successfully!');
}


    public function destroy(int $id)
    {
        $posts = Posts::findOrFail($id);
        if (File::exists($posts->images)) {
            File::delete($posts->images);
        }
        $posts->delete();

        return redirect()->back()->with('status', 'Business Listing Successfully Deleted');
    }

    public function toggleStatus($id)
    {
        $posts = Posts::findOrFail($id);
        $posts->update(['is_active' => !$posts->is_active]);

        return redirect()->back();
    }

    public function sortTable(Request $request)
    {
        $query = Posts::query();

        // Sorting
        if ($request->has('sort')) {
            if ($request->input('sort') == 'newest') {
                $query->orderBy('id', 'desc');
            } elseif ($request->input('sort') == 'oldest') {
                $query->orderBy('id', 'asc');
            }
        }


        // Filtering by is_active
        if ($request->has('filter')) {
            if ($request->input('filter') == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->input('filter') == 'not_active') {
                $query->where('is_active', 0);
            }
        }

        // Pagination
        $limit = $request->input('limit', 10);
        if ($limit == 'all') {
            $ManagePost = $query->get();
        } else {
            $ManagePost = $query->paginate($limit);
        }

        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        return view('category.index', compact('ManagePost', 'unseenCount'));

    }

}
