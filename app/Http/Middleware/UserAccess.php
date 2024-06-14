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

         // HTML content for access denied
         $htmlContent = '
         <!DOCTYPE html>
         <html>
         <head>
         <title>Access Denied</title>
         <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
         <meta charset="UTF-8">
         <link rel="stylesheet" href="style.css">
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
         </head>
         <body>
         <div class="w3-display-middle">
         <h1 class="w3-jumbo w3-animate-top w3-center"><code>Access Denied</code></h1>
         <hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
         <h3 class="w3-center w3-animate-right">You dont have permission to view this site.</h3>
         <h3 class="w3-center w3-animate-zoom">🚫🚫🚫🚫</h3>
         <h6 class="w3-center w3-animate-zoom">error code:403 forbidden</h6>
         </div>
         </body>
         </html>';

         return response($htmlContent, 403)
                ->header('Content-Type', 'text/html');
     }
 }
