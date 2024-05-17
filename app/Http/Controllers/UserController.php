<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $unseenCount = DB::table('ch_messages')->where('to_id', '=' , Auth::user()->id)->where('seen' ,'=' , '0')->count();
        return view('users.index', compact('users','unseenCount'));
    }

    public function create()
    {
        $users = User::all();
        $unseenCount = DB::table('ch_messages')->where('to_id', '=' , Auth::user()->id)->where('seen' ,'=' , '0')->count();
        return view('users.create', compact('users','unseenCount'));
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        return view('users.edit', compact('user'));
    }


    public function store(Request $request)
{
    // Validation
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'type' => 'required',
        'status' => 'required',
    ]);

    // Determine if the user is active based on request status
    $is_active = $request->input('status') == 1 ? true : false;

    // Hash the password
    $userData = $request->all();
    $userData['password'] = Hash::make($request->input('password'));

    // Map user type string to integer value
    $typeMap = [
        'user' => 0,
        'admin' => 1,
        'business' => 2,
    ];
    $userData['type'] = $typeMap[$request->input('type')];

    // Handle image upload
    if ($request->hasFile('image')) {
        $path = 'uploads/users/';
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move($path, $filename);
        $userData['image'] = $path . $filename;
    }

    // Set email_verified_at to current timestamp
    $userData['email_verified_at'] = now();

    // Set account expiration date to null for 'user' and 'admin' types
    if (in_array($request->input('type'), ['user', 'admin'])) {
        $userData['account_expiration_date'] = null;
    }

    // Add is_active field to user data
    $userData['is_active'] = $is_active;

    User::create($userData);

    return redirect()->route('users')->with('message', 'User created successfully!');
}




public function update(Request $request, $userId)
{


    $user = User::findOrFail($userId);

    // Validate request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $userId,
        'type' => 'required|string|in:user,admin,business',
        'status' => 'required|boolean',
        'password' => 'nullable|string|min:8|confirmed',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Map user type string to integer value
    $typeMap = [
        'user' => 0,
        'admin' => 1,
        'business' => 2,
    ];

    // Update user details
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->type = $typeMap[$request->input('type')];
    $user->status = $request->input('status');

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    // Handle image update
    if ($request->hasFile('image')) {
        $path = 'uploads/users/';
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move(public_path($path), $filename);

        // Delete the old image file if it exists
        if ($user->image && File::exists(public_path($user->image))) {
            File::delete(public_path($user->image));
        }

        // Update the user's image path
        $user->image = $path . $filename;
    }

    // Set account expiration date to null for 'user' and 'admin' types
    if (in_array($request->input('type'), ['user', 'admin'])) {
        $user->account_expiration_date = null;
    }

    // Update the is_active field based on the status field
    $user->is_active = $user->status == 1 ? 1 : 0;

    // Save changes
    $user->save();



    return redirect()->route('users')->with('message', 'User updated successfully!');
}




public function toggleStatus($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Toggle the status field between 0 and 1
    $user->status = $user->status == 1 ? 0 : 1;

    // Update the is_active field based on the updated status
    $user->is_active = $user->status;

    // Save the changes
    $user->save();

    return redirect()->back()->with('success', 'User status toggled successfully.');
}



    public function destroy($userId)
    {
        // Logic to delete user
        $user = User::find($userId);
        $user->delete();

        return redirect()->route('users')->with('message', 'User deleted successfully!');
    }

    public function sortTable(Request $request)
    {
        // Initialize query builder for User model
        $query = User::query();

        // Sorting
        if ($request->has('sort')) {
            if ($request->input('sort') == 'newest') {
                $query->orderByDesc('id');
            } elseif ($request->input('sort') == 'oldest') {
                $query->orderBy('id');
            }
        }


        // Filtering by status
        if ($request->has('filter')) {
            $filterValue = $request->input('filter');
            if ($filterValue === '1' || $filterValue === '0') {
                $query->where('status', $filterValue);
            }
        }

        // Pagination limit
            $limit = $request->input('limit', 10);
            if ($limit == 'all') {
                $users = $query->get();
            } else {
                $users = $query->paginate($limit);
                $users->appends(['limit' => $limit]); // Append the limit to the pagination links
            }


            // Fetch unseen message count
            $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();


            // Pass both variables to the view
            return view('users.index', compact('users', 'unseenCount'));
    }
}
