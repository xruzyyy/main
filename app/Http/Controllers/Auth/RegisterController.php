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
        ];

        // If the selected type is not 'user', require the image
        if ($data['type'] !== 'user') {
            $rules['image'] = ['required', 'mimes:jpg,jpeg,webp,png,jfif'];
        }

        return Validator::make($data, $rules);
    }

    

    protected function create(array $data)
    {
        $path = '';
        $filename = '';
        
        if (isset($data['image'])) {
            $file = $data['image'];
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/users/';
            $file->move($path, $filename);
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
    
        // Create the user without adding expiration if the type is 'user' or 'admin'
        if (in_array($data['type'], ['user', 'admin'])) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'image' => $path . $filename,
                'status' => $status,
                'type' => $typeMap[$data['type']],
                'account_expiration_date' => null, // Set account expiration date to null for 'user' and 'admin' types
            ]);
        } else {
            // For business type, add expiration logic
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'image' => $path . $filename,
                'status' => $status,
                'type' => $typeMap[$data['type']],
                'account_expiration_date' => $expirationDate, // Set account expiration date for 'business' type
            ]);
        }
    
        // Trigger the NewUserRegistered event
        event(new NewUserRegistered($user, $user->type));
    
        return $user;
    }
    

    protected function registered(Request $request, $user)
    {
        event(new Registered($user));
        return redirect()->route('verification.notice');
    }

   
}
