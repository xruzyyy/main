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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
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
             
         return response()->json(['message' => 'You do not have permission to access this page.'], 403);
     }
}