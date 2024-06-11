<?php

// app/Http/Controllers/ScheduleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Models\Posts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManageBusinessController extends Controller
{
    public function ManageBusiness(Request $request)
    {
        $action = $request->input('action');

        switch ($action) {
            case 'check-new-expired':
                // Perform the action to check for new expired accounts and disable them
                Artisan::call('accounts:disable');

                // Update is_active attribute based on status
                $usersToUpdate = User::where('account_expiration_date', '<', now())
                                    ->orWhere('status', 0)
                                    ->get();

                foreach ($usersToUpdate as $user) {
                    $user->is_active = $user->status;
                    $user->save();
                }

                Session::flash('info_message', 'Checked for new expired accounts and disabled them.');
                break;

            case 'show-not-expired':
                // Retrieve active business users where account_expiration_date is in the future and type is 2 (business)
                $activeUsersData = User::where('type', 2)
                    ->where('account_expiration_date', '>=', now())
                    ->where('status', 1)
                    ->get();

                    $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();

                    return view('admin.users.manageBusiness')
                    ->with(compact('unseenCount', 'activeUsersData'))
                    ->with('action', 'show-not-expired');


                case 'show-expired-list':
                    // Retrieve expired business users where account_expiration_date has passed and status is still active (1) and type is 2 (business)
                    $expiredUsersData = User::where('type', 2)
                        ->where('account_expiration_date', '<', now())
                        ->where('status', 1)
                        ->get();

                    // Fetch unseen message count
                    $unseenCount = DB::table('ch_messages')
                        ->where('to_id', '=', Auth::user()->id)
                        ->where('seen', '=', '0')
                        ->count();

                    return view('admin.users.manageBusiness')
                                ->with(compact('unseenCount', 'expiredUsersData'))
                                ->with('action', 'show-expired-list');


            case 'show-inactive-list':
                // Retrieve inactive business users where account_expiration_date has passed or status is 0 and type is 2 (business)
                $inactiveUsersData = User::where('type', 2)
                    ->where(function ($query) {
                        $query->where('account_expiration_date', '<', now())
                            ->orWhere('status', 0);})
                    ->get();

                    $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();


                    return view('admin.users.manageBusiness')
                    ->with(compact('unseenCount', 'inactiveUsersData'))
                    ->with('action', 'show-inactive-list');


                    case 'show-rejected-list':
                        // Retrieve rejected business users where status is 3 and type is 2 (business)
                        $rejectedUsersData = User::where('type', 2)
                            ->where('status', 3)
                            ->get();

                        $unseenCount = DB::table('ch_messages')
                            ->where('to_id', '=', Auth::user()->id)
                            ->where('seen', '=', '0')
                            ->count();

                        return view('admin.users.manageBusiness')
                            ->with(compact('unseenCount', 'rejectedUsersData'))
                            ->with('action', 'show-rejected-list');



            case 'check-new-expired':
                // Retrieve expired business users where account_expiration_date has passed and status is still active (1) and type is 2 (business)
                $expiredUsers = User::where('type', 2)
                    ->where('account_expiration_date', '<', now())
                    ->where('status', 1)
                    ->get();

                // Loop through expired users and disable their categories
                foreach ($expiredUsers as $user) {
                    $user->categories()->update(['is_active' => false]);
                }

                // Flash a message to indicate the action
                Session::flash('info_message', 'Checked for new expired accounts and disabled associated categories.');
                break;

                default:
                $user = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

                $labels = [];
                $data = [];

                for ($i = 1; $i <= 12; $i++) {
                    $month = date('F', mktime(0, 0, 0, $i, 1));
                    array_push($labels, $month);
                }

                for ($i = 1; $i <= 12; $i++) {
                    $count = 0;

                    foreach ($user as $usr) {
                        if ($usr->month == $i) {
                            $count = $usr->count;
                        }
                    }

                    array_push($data, $count);
                }

                $userData = [
                    'labels' => $labels,
                    'data' => [
                        [
                            'label' => 'Registered Users',
                            'data' => $data,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                            'borderColor' => 'rgba(75, 192, 192, 1)',
                            'borderWidth' => 1,
                        ],
                    ],
                ];



                return view('admin.adminDashboard')->with('userData', $userData);

        }

        // Redirect back to the page
        return redirect()->route('manageBusinessForm');
    }

    public function ManageBusinessForm()
    {
        // Retrieve success and info messages from the session
        $successMessage = Session::get('success_message');
        $infoMessage = Session::get('info_message');

        // Retrieve expired users data from the session
        $expiredUsersData = Session::get('expired_users_data');

        // Return the view with the messages and expired users data
        return back()->with(compact('successMessage', 'infoMessage', 'expiredUsersData'));
    }

     // Method to update categories' is_active field based on the user's status
     public function updateUserStatus(Request $request)
     {
         $userId = $request->input('user_id');
         $status = $request->input('status');

         // Update the is_active field of associated categories based on the user's status
         Posts::where('user_id', $userId)->update(['is_active' => $status]);

         return response()->json(['message' => 'Categories updated successfully']);
     }
}
