<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BusinessProfileController extends Controller
{
    public function show($id = null)
    {
        // Fetch the authenticated user
        $user = auth()->user();
        // Check if $id is provided, if not, use the authenticated user's ID
        if ($id === null) {
            $id = $user->id;
        }

        // Fetch the post and unseen message count
        $post = Posts::findOrFail($id);
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', $id)
            ->where('seen', '=', '0')
            ->count();

        // Assuming you have a view named 'profile.blade.php' in 'resources/views/business-section'
        return view('business-section.profile', compact('user', 'post', 'unseenCount'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::findOrFail($id);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $profileImagePath = 'uploads/profile_images/';
            $profileImageName = time() . '_profile.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->move(public_path($profileImagePath), $profileImageName);

            // Delete old profile image if exists
            if ($user->profile_image) {
                // Extract the filename from the full path stored in the database
                $filename = basename($user->profile_image);
                // Construct the full server path
                $fullPath = public_path($profileImagePath . $filename);
                // Check if the file exists before attempting to delete it
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            // Update profile image path
            $user->profile_image = $profileImagePath . $profileImageName;
        }


        // Update user details
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('status', 'User profile updated successfully!');
    }
}
