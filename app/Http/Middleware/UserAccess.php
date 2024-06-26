<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $userType
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        $currentUserType = auth()->user()->type;

        // Allow access for admin regardless of the specified user type
        if ($currentUserType == 'admin') {
            return $next($request);
        }

        // Check if the user type matches the specified user type in the middleware
        if ($currentUserType == $userType) {
            return $next($request);
        }

        // Redirect to home page based on user type
        if ($currentUserType == 'user') {
            return redirect('/home');
        } elseif ($currentUserType == 'business') {
            return redirect('/business/home');
        }
        // else
        // {
        //     return redirect('/login');
        // }
        

        // For any other case, return access denied (403)
        // abort(403, 'Unauthorized action.');
    }
}
