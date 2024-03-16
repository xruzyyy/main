<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // Counting total users
        $count['users'] = User::count();

       // Counting inactive users (users with status 0 and type 2)
        $count['inactive'] = User::where('status', 0)
        ->where('type', 2)
        ->count();

        // Counting active users (users with status 1 and type 2)
        $count['active'] = User::where('status', 1)
        ->where('type', 2)
        ->count();

        // Logic for retrieving expired business users
        $count['expired'] = User::where('type', 2)
            ->where('account_expiration_date', '<', Carbon::now())
            ->where('status', 1)
            ->count();

        $count['activebusiness'] = User::where('type', 2)
            ->where('account_expiration_date', '>', Carbon::now())
            ->where('status', 1)
            ->count();


        // Counting total listings (categories)
        $count['listing'] = Category::count();

        // Counting inactive listings
        $count['inactive_listings'] = Category::where('is_active', 0)->count();


       // Counting expired listings
        $count['expired_listings'] = Category::where('is_active', 1)
        ->whereHas('user', function ($query) {
            $query->where('status', 1)
                ->where('account_expiration_date', '<', now());
        })
        ->count();



        // Counting active listings
        $count['active_listings'] = Category::where('is_active', 1)->count();

        

       // Counting active business users over time
        $activeBusinessUsersOverTime = User::where('status', 1)
        ->where('type', 2) // Assuming type 2 represents business users
        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();



        // Extracting creation dates for each user
        $userCreationDates = User::select('created_at')->get()->pluck('created_at')->map(function ($date) {
            return $date->toDateString(); // Extracting the date part
        });

        // Logic to retrieve user creation data
        $userCreationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('type', 2) // Filter for type 2 users (business users)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(36500)) 
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Logic to retrieve user creation data
        $normalUserCreationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('type', 0) // Filter for type 0 users (normal users)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(36500)) 
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
         // Fetch expired accounts
        $expiredAccounts = User::where('type', 2)
        ->where('status', 1)
        ->where('account_expiration_date', '<', now())
        ->get();

         // Fetch pending accounts
         $pendingAccounts = User::where('type', 2)
        ->where('status', 0) // Assuming status 0 represents pending accounts
        ->get();

        
        // Retrieve pending business user registrations
        $pendingBusinessUsers = User::where('type', 2)
        ->where('status', 0)
        ->get();
        
        return view('admin.adminDashboard', compact('count','pendingBusinessUsers','userCreationDates', 'userCreationData','normalUserCreationData','expiredAccounts','pendingAccounts'));
    
    }
    

}