<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    // Check if the provided email exists in the database
    if (!User::where('email', $request->email)->exists()) {
        return redirect()->route('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Attempt authentication
    if (Auth::attempt($credentials, $remember)) {
        if (!Auth::user()->email_verified_at) {
            return redirect()->route('login')->withErrors(['email_verification' => 'Please verify your email.']);
        }

         // If the status is not approved, log out the user and redirect to login
         if (Auth::user()->type  = 2 && Auth::user()->status = 3) {
            return redirect('update_account_details')->withErrors('Your Account Is Rejected, Please Update the details!');
        }

       elseif (Auth::user()->status != 1) {
            Auth::logout();
            return redirect('/login')->withErrors('Your Account Is Under Checking Status!');
        }

        // Check user type and redirect accordingly
        switch (Auth::user()->type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'business':
                if (Auth::user()->type == 3) {
                    return redirect()->route('update_account_details');
                }
                elseif(Auth::user()->type == 2){
                Artisan::call('accounts:disable');
                return redirect()->route('business.home');
            }
            default:
                Artisan::call('accounts:disable');
                return redirect()->route('home');
        }
    }

    // If the email and password combination is incorrect
    return redirect()->route('login')->withErrors([
        'password' => 'The provided password is incorrect.',
    ]);
}

}
