<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Events\ProfileUpdated; // Correct event name

class BusinessProfileController extends Controller
{
    public function show($id = null)
    {
        $user = auth()->user();
        if ($id === null) {
            $id = $user->id;
        }

        $post = Posts::where('user_id', $id)->first(); // Fetch the post associated with the user
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', $id)
            ->where('seen', '=', '0')
            ->count();

        return view('business-section.profile', compact('user', 'post', 'unseenCount'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => ['nullable', 'min:8', 'confirmed'],
            'current_password' => ['required', function ($attribute, $value, $fail) use ($id) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->input('email');

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $profileImagePath = 'uploads/profile_images/';
            $profileImageName = time() . '_profile.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->move(public_path($profileImagePath), $profileImageName);

            // Delete old profile image if exists
            if ($user->profile_image) {
                $filename = basename($user->profile_image);
                $fullPath = public_path($profileImagePath . $filename);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            $user->profile_image = $profileImagePath . $profileImageName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // Fire the event after saving user details
        event(new ProfileUpdated($user));

        return redirect()->back()->with('status', 'User profile updated successfully!');
    }



    public function updatePost(Request $request, int $id)
    {
        $request->validate([
            'description' => 'required|max:255|string',
            'contact_number' => 'nullable|string|max:20', // Add validation for contact number
        ]);

        $post = Posts::findOrFail($id);

        // Check if the logged-in user is the owner of the post
        if (Auth::id() !== $post->user_id) {
            return redirect()->back()->withErrors('You are not authorized to edit this post.');
        }

        // Update the post with the new description and contact number
        $post->update([
            'description' => $request->description,
            'contactNumber' => $request->contact_number, // Update the contact number
        ]);

        return redirect()->back()->with('status', 'Post description and contact number updated successfully!');
    }
}
