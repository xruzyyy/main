<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AccountUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class UpdateAccountController extends Controller
{
    public function showUpdateForm()
    {
        // Fetch rejection details
        $user = Auth::user();
        $rejectionDetails = $user->rejection_details; // Assuming 'rejection_details' is the column name in your users table

        return view('auth.update_account_details', ['rejectionDetails' => $rejectionDetails]);
    }


    public function storeAccountUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=480',
        ], [
            'image.dimensions' => 'The permit image must have a width of at least 480 pixels.',
        ]);

        $user = Auth::user();

        // Handle image upload if required
        if ($request->hasFile('image')) {
            $profileImagePath = 'uploads/profile_images/';
            $profileImageName = time() . '_profile.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($profileImagePath, $profileImageName);
            $user->image = $profileImagePath . $profileImageName;
        }

        $user->name = $request->input('name');
        $user->save();

        // Notify admin about the account update
        Notification::route('mail', 'cruzjerome012@gmail.com')
            ->notify(new AccountUpdatedNotification($user));

        return redirect()->route('update_account_details')->with('success', 'Account details updated successfully.');
    }
}
