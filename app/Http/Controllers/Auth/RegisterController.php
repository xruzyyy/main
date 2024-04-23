<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Notifications\NewUserNotification;
use App\Events\NewUserRegistered;
use Illuminate\Support\Facades\Log; // Make sure this line is included
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{



    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

        protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required', 'string', 'in:user,admin,business'],
            'profile_image' => ['required', 'mimes:jpg,jpeg,webp,png,jfif,heic'],

        ];

        // If the selected type is not 'user', require the image
        if ($data['type'] !== 'user') {
            $rules['image'] = ['required', 'mimes:jpg,jpeg,webp,png,jfif'];
        }

        return Validator::make($data, $rules);
    }



    protected function create(array $data)
{
    // Initialize variables for image handling
    $imagePath = '';
    $imageName = '';

    // Check if profile image is uploaded
    if (isset($data['profile_image'])) {
        $image = $data['profile_image'];
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;
        $imagePath = 'uploads/profile_images/';
        $image->move($imagePath, $imageName);
    }

    // Map user type string to integer value
    $typeMap = [
        'user' => 0,
        'admin' => 1,
        'business' => 2,
    ];

    // Set status to 1 if user type is 'user' or 'admin', otherwise set to 0
    $status = in_array($data['type'], ['user', 'admin']) ? 1 : 0;

    // Define expiration date for business type
    $expirationDate = null;
    if ($data['type'] === 'business') {
        $expirationDate = Carbon::now('Asia/Manila')->addYear();
    }

    // Set is_active to true for 'user' type, otherwise false
    $isActive = in_array($data['type'], ['user', 'admin']) ? 1 : 0;

    // Create the user
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'image' => $imagePath . $imageName, // Store profile image path
        'profile_image' => $imagePath . $imageName, // Store profile image path
        'status' => $status,
        'is_active' => $isActive,
        'type' => $typeMap[$data['type']],
        'role_as' => $data['type'] === 'business' ? 'business' : ($typeMap[$data['type']] === 0 ? 'user' : 'admin'), // Set role_as based on user type
        'account_expiration_date' => $data['type'] === 'business' ? $expirationDate : null, // Set account expiration date for 'business' type
    ]);

    // Trigger the NewUserRegistered event
    event(new NewUserRegistered($user, $user->type));

    // Send notification to the specific email address
    Notification::route('mail', 'cruzjerome012@gmail.com')
        ->notify(new NewUserNotification($user));

    return $user;
}








    // protected function registered(Request $request, $user)
    // {
    //     event(new Registered($user));
    //     return redirect()->route('verification.notice');
    // }


}
