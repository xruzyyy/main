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
        $posts = Posts::with('ratings')->latest()->take(6)->get(['id','user_id', 'businessName', 'description', 'images', 'latitude', 'longitude', 'is_active','type','contactNumber']);

        return view('userPage.home', [
            'unseenCount' => $unseenCount ,
            'latestPosts' => $latestPosts,
            'posts' => $posts ],
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
        // Fetch the count of unseen messages (replace with your actual method)
        $unseenCount = $this->fetchUnseenMessageCount();

        $posts = Posts::orderBy('created_at', 'desc')->get();

        return view('business-section.businessHome', [
            'unseenCount' => $unseenCount,
            'posts' => $posts,

        ]);
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
        return view('userPage.Home', [
            'posts' => $latestActivePosts,
            'unseenCount' => $this->fetchUnseenMessageCount(),
            'latestPosts' => $latestPosts,
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
