<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Notifications\NewUserNotification;
use App\Events\NewUserRegistered;
use Illuminate\Auth\Events\Registered;
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
    $messages = [
        'image.dimensions' => 'The permit image dimensions must be at least 480x480 pixels.',
        'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, and one numeric digit.',
        'password.confirmed' => 'The passwords do not match.',
    ];

    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        'type' => ['required', 'string', 'in:user,admin,business'],
        'profile_image' => ['required', 'mimes:jpg,jpeg,webp,png,jfif,heic'],
    ];

    // If the selected type is not 'user', require the permit image
    if ($data['type'] !== 'user') {
        $rules['image'] = ['required', 'mimes:jpg,jpeg,webp,png,jfif', 'dimensions:min_width=480,min_height=480'];
    }

    return Validator::make($data, $rules, $messages);
}





    protected function create(array $data)
    {
        // Handle profile image upload
        if (isset($data['profile_image'])) {
            $profileImagePath = 'uploads/profile_images/';
            $profileImageName = time() . '_profile.' . $data['profile_image']->getClientOriginalExtension();
            $data['profile_image']->move($profileImagePath, $profileImageName);
        }

        // Handle permit image upload if required
        $permitImageName = null;
        if ($data['type'] !== 'user' && isset($data['image'])) {
            $permitImagePath = 'uploads/permit_images/';
            $permitImageName = time() . '_permit.' . $data['image']->getClientOriginalExtension();
            $data['image']->move($permitImagePath, $permitImageName);
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
            $expirationDate = now()->addYear();
        }

        // Set is_active to true for 'user' type, otherwise false
        $isActive = in_array($data['type'], ['user', 'admin']) ? 1 : 0;

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => $permitImageName ? 'uploads/permit_images/' . $permitImageName : null, // Use permit image if available
            'profile_image' => isset($profileImageName) ? 'uploads/profile_images/' . $profileImageName : null, // Use profile image if available
            'status' => $status,
            'is_active' => $isActive,
            'type' => $typeMap[$data['type']],
            'role_as' => $data['type'] === 'business' ? 'business' : ($typeMap[$data['type']] === 0 ? 'user' : 'admin'),
            'account_expiration_date' => $data['type'] === 'business' ? $expirationDate : null,
        ]);

        // Trigger the NewUserRegistered event
        event(new NewUserRegistered($user, $user->type));

        // // Send notification to the specific email address
        // Notification::route('mail', 'misoutcompany@gmail.com')
        //     ->notify(new NewUserNotification($user));

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        event(new Registered($user));
        return redirect()->route('verification.notice');
    }
}
