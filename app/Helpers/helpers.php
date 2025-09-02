<?php

use App\Models\School;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

if (! function_exists('setSchoolSession')) {
    function setSchoolSession(): void
    {
        if (!Auth::check()) {
            Cookie::queue(Cookie::forget('school_year'));
            return;
        }

        $lifetime = env('SESSION_LIFETIME', 120);

        $year = Year::where('status', '<>', 'ended')->orderByDesc('id')->first();

        if ($year) {
            $encrypted = encrypt($year->toJson());
            Cookie::queue(Cookie::make('school_year', $encrypted, $lifetime));
        }
    }
}

if (! function_exists('getDecryptedSchoolSession')) {
    function getDecryptedSchoolSession(): ?Year
    {
        try {
            if (!Auth::check()) {
                Cookie::queue(Cookie::forget('school_year'));
                return null;
            }

            $encrypted = Cookie::get('school_year');
            if (! $encrypted) {
                return null;
            }

            $decryptedJson = decrypt($encrypted);
            $yearArray = json_decode($decryptedJson, true);

            return Year::find($yearArray['id'] ?? null);
        } catch (\Exception $e) {
            Cookie::queue(Cookie::forget('school_year'));
            return null;
        }
    }
}

if (! function_exists('getSuperAdminAndSchoolAdminPrivileges')) {
    function getSuperAdminAndSchoolAdminPrivileges(): void
    {
        $user = Auth::user();

        if (! $user || ! $user->roles()->whereIn('name', ['school-admin', 'super-admin'])->exists()) {
            abort(403, 'Not authorized to view users.');
        }
    }
}

if (! function_exists('getSuperAdminPrivileges')) {
    function getSuperAdminPrivileges(): void
    {
        if (!Auth::check()) {
            Cookie::queue(Cookie::forget('schoolFx'));
            abort(403, 'Authentication required.');
        }

        $user = Auth::user();
        if (! $user->roles()->where('name', 'super-admin')->exists()) {
            abort(403, 'Not authorized to view users.');
        }
    }
}

if (! function_exists('getUserSchool')) {
    function getUserSchool(): void
    {
        if (!Auth::check()) {
            Cookie::queue(Cookie::forget('schoolFx'));
            return;
        }

        $lifetime = env('SESSION_LIFETIME', 120);
        $user = Auth::user();

        if (! $user->school_id && ! $user->roles()->where('name', 'super-admin')->exists()) {
            abort(403, 'Not authorized to use app. Contact the school administrator.');
        }

        $school = School::where('is_locked', false)
            ->where('id', $user->school_id)
            ->first();

        if ($school) {
            $encrypted = encrypt($school->toJson());
            Cookie::queue(Cookie::make('schoolFx', $encrypted, $lifetime));
        }
    }
}

if (! function_exists('getDecryptedSchoolFx')) {
    function getDecryptedSchoolFx(): ?School
    {
        try {
            if (!Auth::check()) {
                Cookie::queue(Cookie::forget('schoolFx'));
                return null;
            }

            $encrypted = Cookie::get('schoolFx');
            if (! $encrypted) {
                return null;
            }

            $decryptedJson = decrypt($encrypted);
            $schoolArray = json_decode($decryptedJson, true);

            return School::find($schoolArray['id'] ?? null);
        } catch (\Exception $e) {
            Cookie::queue(Cookie::forget('schoolFx'));
            return null;
        }
    }
}

