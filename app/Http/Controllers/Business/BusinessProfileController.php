<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function update(Request $request, User $user)
    {
        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save changes
        $user->save();

        return redirect()->route('showProfile')->with('message', 'User updated successfully!');
    }
}
