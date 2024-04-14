<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\DB;
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
        return view('home', ['unseenCount' => $unseenCount]);
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

    public function businessHome()
    {
        $unseenCount = $this->fetchUnseenMessageCount();
        return view('businessHome', ['unseenCount' => $unseenCount]);
    }

    public function businessPostList(Request $request)
{
    // Retrieve categories from the database
    $unseenCount = $this->fetchUnseenMessageCount();

    // Retrieve the 7 latest categories from the database
    $categories = Category::latest()->take(6)->get(['id','user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active','type','contactNumber']);

    // Pass category data and any other necessary data to the view
    return view('businessHome', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}


    private function fetchUnseenMessageCount()
    {
        return DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
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
