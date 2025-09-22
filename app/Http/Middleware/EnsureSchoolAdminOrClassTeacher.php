<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolAdminOrClassTeacher
{
     public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

         $user = Auth::user();
       if (!$user) {
            abort(403, 'Not authenticated');
        }

        if ($user->school && $user->school->is_locked) {
            abort(403, 'School is locked');
        }

        if (! $user->hasRole('school-admin') &&  ! $user->hasRole('class-teacher') ) {
            return abort(403,'Access denied - You are not authorised to use this page ' );
        }


        return $next($request);
    }
}
