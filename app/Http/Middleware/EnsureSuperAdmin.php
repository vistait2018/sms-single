<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();



        if (! $user || ! $user->hasRole('super-admin')) {
             return abort(403,'Access denied - You are not authorised this .You should not be here' );
        }

        return $next($request);
    }
}
