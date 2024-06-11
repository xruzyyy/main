<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the user is authenticated and the email is not verified
        if (Auth::check() && !Auth::user()->email_verified_at) {
            // Redirect the user to the verify-email route
            return redirect()->route('verify-email');
        }


        // If the status is not approved, log out the user and redirect to login
        if (Auth::check() && Auth::user()->status == 3) {
            Auth::logout();
            return redirect('login')->withErrors('Your Account Is Currently Rejected, Kindly Update The Details');
        }

        // If the status is not approved, log out the user and redirect to login
        if (Auth::user()->status != 1 && Auth::user()->status != 3) {
            Auth::logout();
            return redirect('/login')->withErrors('Your Account Is Under Checking Status!');
        }


        return $next($request);
    }
}
