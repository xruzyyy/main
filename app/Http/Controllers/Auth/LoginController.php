<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

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
    $remember = $request->has('remember'); // Check if the "Remember Me" checkbox is checked

    if (Auth::attempt($credentials, $remember)) {
        if (!Auth::user()->email_verified_at) {
            Auth::logout();
            return redirect()->route('verification.notice')->withErrors('Please verify your email.');
        }

        if (Auth::user()->status != 1) {
            Auth::logout();
            return redirect('/login')->withErrors('Your Account Is Under Checking Status!');
        }

        if (Auth::user()->type == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->type == 'business') {
            return redirect()->route('business.home');
        } else {
            return redirect()->route('home');
        }
    }

    return redirect()->route('login')->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


}
