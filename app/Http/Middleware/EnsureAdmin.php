<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only run this check for authenticated users; guests will be redirected by Filament's Authenticate middleware
        if (Auth::check() && ! (Auth::user()->is_admin ?? false)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to the admin panel.');
        }

        return $next($request);
    }
}
