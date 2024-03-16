<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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

        // Set account expiration date to null for 'user' and 'admin' types
        if (in_array($request->input('type'), ['user', 'admin'])) {
            $userData['account_expiration_date'] = null;
        }

        User::create($userData);

        return redirect()->route('users')->with('message', 'User created successfully!');
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Validate request data as needed

        // Map user type string to integer value
        $typeMap = [
            'user' => 0,
            'admin' => 1,
            'business' => 2,
        ];

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->type = $typeMap[$request->input('type')]; // Map type value
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
            $file->move($path, $filename);

            // Delete the old image file if it exists
            if (File::exists($user->image)) {
                File::delete($user->image);
            }

            // Update the user's image path
            $user->image = $path . $filename;
        }

        // Set account expiration date to null for 'user' and 'admin' types
        if (in_array($request->input('type'), ['user', 'admin'])) {
            $user->account_expiration_date = null;
        }

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

        // Toggle the status
        $user->status = !$user->status;
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
                $query->orderBy('created_at', 'desc');
            } elseif ($request->input('sort') == 'oldest') {
                $query->orderBy('created_at', 'asc');
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

        // Return view with paginated or all users data
        return view('users.index', compact('users'));
    }
}
