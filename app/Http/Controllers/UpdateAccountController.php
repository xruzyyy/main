<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateAccountController extends Controller
{
    public function showUpdateForm()
    {
        return view('auth.update_account_details');
    }

    public function storeAccountUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle image upload if required
        if ($request->hasFile('image')) {
            $permitImagePath = 'uploads/permit_images/';
            $permitImageName = time() . '_permit.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($permitImagePath, $permitImageName);
            $user->image = $permitImagePath . $permitImageName;
        }

        $user->name = $request->input('name');
        $user->save();

        return redirect()->route('business.home')->with('success', 'Account details updated successfully.');
    }
}
