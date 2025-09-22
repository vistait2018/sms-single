<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         $user = Auth::user();
       if (!$user) {
            abort(403, 'Not authenticated');
        }

        if ($user->school && $user->school->is_locked) {
            abort(403, 'School is locked');
        }

        if (! $user->hasRole('school-admin') ) {
            return abort(403,'Access denied - You are not authorised to use this page or your School has been locked' );
        }


        return $next($request);
    }
}
