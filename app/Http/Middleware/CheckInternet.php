<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInternet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isConnected()) {
            abort(503, 'No Internet Connection');
        }

        return $next($request);
    }

    private function isConnected(): bool
    {
        try {
            // Try to open a socket to Google DNS (8.8.8.8:53)
            $connected = @fsockopen("8.8.8.8", 53, $errno, $errstr, 2);
            if ($connected) {
                fclose($connected);
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }

        return false;
    }
}
