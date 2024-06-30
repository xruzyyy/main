<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Posts;
use App\Notifications\NewUserNotification;
use App\Notifications\NewCommentNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Validation\Rule; // Import Rule class for validation rules

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $unseenCount = $this->fetchUnseenMessageCount();
    $latestPosts = Posts::orderBy('created_at', 'desc')->get();
    $posts = Posts::with('ratings')->latest()->take(6)->get(['id', 'user_id', 'businessName', 'description', 'images', 'latitude', 'longitude', 'is_active', 'type', 'contactNumber', 'monday_open', 'monday_close', 'tuesday_open', 'tuesday_close', 'wednesday_open', 'wednesday_close', 'thursday_open', 'thursday_close', 'friday_open', 'friday_close', 'saturday_open', 'saturday_close', 'sunday_open', 'sunday_close']);

    $current_time = \Carbon\Carbon::now()->setTimezone(config('app.timezone'));

    return view(
        'userPage.home',
        [
            'unseenCount' => $unseenCount,
            'latestPosts' => $latestPosts,
            'posts' => $posts,
            'current_time' => $current_time
        ]
    );
}


    public function adminDashboard()
    {
        $unseenCount = $this->fetchUnseenMessageCount();
        return view('admin.dashboard', ['unseenCount' => $unseenCount]);
    }

    public function adminManageBusiness()
    {
        $unseenCount = $this->fetchUnseenMessageCount();
        return view('admin.users.manageBusiness', ['unseenCount' => $unseenCount]);
    }
    public function adminManageUser()
    {
        $unseenCount = $this->fetchUnseenMessageCount();

        // Fetch users with type 0 (normal users)
        $users = User::where('type', 'user')->get();

        return view('admin.users.manageUser', [
            'unseenCount' => $unseenCount,
            'users' => $users
        ]);
    }

    public function businessHome()
{
    // Check if the user already has a listing
    $updateListing = Posts::where('user_id', auth()->user()->id)->exists();

    // If the user already has a listing, redirect to the update route
    if ($updateListing) {
        return redirect()->route('listings.update', ['id' => auth()->user()->id]);
    }

    // Fetch the count of unseen messages (replace with your actual method)
    $unseenCount = $this->fetchUnseenMessageCount();

    $posts = Posts::orderBy('created_at', 'desc')->get();

    return view('business-section.businessHome', [
        'unseenCount' => $unseenCount,
        'posts' => $posts,
    ]);
}


    // Display the map page
    public function mapUpdate()
    {
        // Fetch unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        return view('mapUpdate', ['unseenCount' => $unseenCount]);
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

    public function edit($id)
    {
        $unseenCount = $this->fetchUnseenMessageCount();

        // Fetch the authenticated user and ensure they own the listing
        $listing = Posts::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

        // Extract latitude and longitude from the listing
        $latitude = $listing->latitude;
        $longitude = $listing->longitude;

        // Determine if the user is a business
        $isBusiness = (auth()->user()->type === 'business');

        // Pass the user, listing data, latitude, and longitude to the edit view
        return view('listings.update', [
            'user' => auth()->user(),
            'listing' => $listing,
            'unseenCount' => $unseenCount,
            'isBusiness' => $isBusiness,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }




    public function update(Request $request, $id)
    {
        // Fetch the listing by ID and ensure it belongs to the authenticated user
        $listing = Posts::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

        // Define allowed types
        $allowedTypes = [
            'Accounting', 'Agriculture', 'Construction', 'Education', 'Finance',
            'Retail', 'Fashion Photography Studios', 'Healthcare', 'Coffee Shops',
            'Information Technology', 'Shopping Malls', 'Trading Goods', 'Consulting',
            'Barbershop', 'Fashion Consultancy', 'Beauty Salon', 'Logistics', 'Sports',
            'Pets', 'Entertainment', 'Pattern Making Services', 'Maintenance',
            'Pharmaceuticals', 'Automotive', 'Environmental', 'Quick Service Restaurants',
            'Food & Beverage', 'Garment Manufacturing', 'Fashion Events Management',
            'Retail Clothing Stores', 'Fashion Design Studios', 'Shoe Manufacturing',
            'Tailoring and Alterations', 'Textile Printing and Embroidery',
            'Fashion Accessories', 'Boutiques', 'Apparel Recycling and Upcycling',
            'Apparel Exporters'
        ];

        // Validate the request data
        $request->validate([
            'businessName' => 'required|max:255|string',
            'description' => 'required|max:200|string',
            'contactNumber' => 'required|string|digits_between:10,15',
            'type' => [
                'required',
                Rule::in($allowedTypes),
            ],
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'mondayOpen' => 'nullable',
            'mondayClose' => 'nullable|after:mondayOpen',
            'tuesdayOpen' => 'nullable',
            'tuesdayClose' => 'nullable|after:tuesdayOpen',
            'wednesdayOpen' => 'nullable',
            'wednesdayClose' => 'nullable|after:wednesdayOpen',
            'thursdayOpen' => 'nullable',
            'thursdayClose' => 'nullable|after:thursdayOpen',
            'fridayOpen' => 'nullable',
            'fridayClose' => 'nullable|after:fridayOpen',
            'saturdayOpen' => 'nullable',
            'saturdayClose' => 'nullable|after:saturdayOpen',
            'sundayOpen' => 'nullable',
            'sundayClose' => 'nullable|after:sundayOpen',
        ]);

        // Update the listing with the new data
        $listing->businessName = $request->businessName;
        $listing->description = $request->description;
        $listing->contactNumber = $request->contactNumber;
        $listing->type = $request->type;
        $listing->latitude = $request->latitude;
        $listing->longitude = $request->longitude;

        // Store hours
        $listing->monday_open = $request->mondayOpen;
        $listing->monday_close = $request->mondayClose;
        $listing->tuesday_open = $request->tuesdayOpen;
        $listing->tuesday_close = $request->tuesdayClose;
        $listing->wednesday_open = $request->wednesdayOpen;
        $listing->wednesday_close = $request->wednesdayClose;
        $listing->thursday_open = $request->thursdayOpen;
        $listing->thursday_close = $request->thursdayClose;
        $listing->friday_open = $request->fridayOpen;
        $listing->friday_close = $request->fridayClose;
        $listing->saturday_open = $request->saturdayOpen;
        $listing->saturday_close = $request->saturdayClose;
        $listing->sunday_open = $request->sundayOpen;
        $listing->sunday_close = $request->sundayClose;

        // Handle image uploads
        $paths = [];
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $path = 'uploads/category'; // Adjust path as needed

                // Validate image dimensions
                list($width, $height) = getimagesize($image->getRealPath());
                if ($width < 480 || $height < 480) {
                    return redirect()->back()->withErrors(['images' => 'Each image must be at least 480p resolution.']);
                }

                // Move image to storage
                $image->move($path, $filename);

                // Store image path
                $paths[] = $path . '/' . $filename;
            }
        }

        // Update images field with new paths
        $listing->images = json_encode($paths);

        // Save the updated listing
        $listing->save();

        // Redirect back to the edit form with a success message and flash current input data to session
        return redirect()
            ->route('listings.update', ['id' => $listing->id])
            ->with('success', 'Listing updated successfully!')
            ->withInput();
    }










    private function fetchUnseenMessageCount()
    {
        return DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
    }




    public function businessPostList(Request $request)
    {
        // Retrieve the latest active posts and the latest posts overall
        $latestActivePosts = Posts::where('is_active', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $latestPosts = Posts::orderBy('created_at', 'desc')->get();

        // If the latest active posts are less than 6, fetch the additional active posts to fill up to 6
        if ($latestActivePosts->count() < 6) {
            $additionalActivePosts = Posts::where('is_active', 1)
                ->whereNotIn('id', $latestActivePosts->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->take(6 - $latestActivePosts->count())
                ->get();
            $latestActivePosts = $latestActivePosts->merge($additionalActivePosts);
        }

        // Pass post data and any other necessary data to the view
        return view('business-section.businessHome', [
            'posts' => $latestActivePosts,
            'unseenCount' => $this->fetchUnseenMessageCount(),
            'latestPosts' => $latestPosts,
        ]);
    }

    public function businessPostListForUser(Request $request)
    {
        // Retrieve the latest active posts and the latest posts overall
        $latestActivePosts = Posts::where('is_active', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $latestPosts = Posts::orderBy('created_at', 'desc')->get();

        // If the latest active posts are less than 6, fetch the additional active posts to fill up to 6
        if ($latestActivePosts->count() < 6) {
            $additionalActivePosts = Posts::where('is_active', 1)
                ->whereNotIn('id', $latestActivePosts->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->take(6 - $latestActivePosts->count())
                ->get();
            $latestActivePosts = $latestActivePosts->merge($additionalActivePosts);
        }

        // Pass post data and any other necessary data to the view
        return view('userPage.home', [
            'posts' => $latestActivePosts,
            'unseenCount' => $this->fetchUnseenMessageCount(),
            'latestPosts' => $latestPosts,
        ]);
    }

    // Method to display all business posts
    public function indexFeatured()
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
    public function showFeatured($id)
    {
        // Fetch the business post by ID
        $post = Posts::findOrFail($id);

        // Retrieve the latest active posts
        $latestActivePosts = Posts::where('is_active', 1)->orderBy('created_at', 'desc')->take(6)->get();

        // If the latest active posts are less than 6, fetch the additional active posts to fill up to 6
        if ($latestActivePosts->count() < 6) {
            $additionalActivePosts = Posts::where('is_active', 1)
                ->whereNotIn('id', $latestActivePosts->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->take(6 - $latestActivePosts->count())
                ->get();
            $latestActivePosts = $latestActivePosts->merge($additionalActivePosts);
        }

        // Pass the post data and the latest active posts to the view
        return view('business-section.postsFeatured', [
            'post' => $post,
            'latestActivePosts' => $latestActivePosts
        ]);
    }




    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('status', 'Notification deleted successfully.');
    }

    public function deleteAllNotifications()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Delete all notifications associated with the user
        $user->notifications()->delete();

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'All notifications have been deleted.');
    }
}
