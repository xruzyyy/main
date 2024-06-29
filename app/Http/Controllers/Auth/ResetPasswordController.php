<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function redirectTo()
    {
        // Determine the type of the authenticated user and set redirect path accordingly
        if (auth()->user()->type === 'business') {
            return '/business/home';
        } elseif (auth()->user()->type === 'admin') {
            return '/admin/home'; // Replace with your admin home path
        } else {
            return '/home'; // Default home path
        }
    }

    /**
     * Get the post reset redirect path.
     *
     * @return string
     */
    public function redirectToReset()
    {
        return $this->redirectTo();
    }
}
