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

        if (Auth::user()->status != 1) {
            Auth::logout();
            return redirect('/login')->withErrors('Your Account Is Under Checking Status!');
        }

        if (Auth::user()->type == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->type == 'business') {
            Artisan::call('accounts:disable');
            return redirect()->route('business.home');
        } else {
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
