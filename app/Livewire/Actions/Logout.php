<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth::guard('web')->logout();
        Cookie::queue(Cookie::forget('school_year'));
        Cookie::queue(Cookie::forget('schoolFx'));
        Session::invalidate();
        Session::regenerateToken();
    }
}
// This class handles the logout action for the application.