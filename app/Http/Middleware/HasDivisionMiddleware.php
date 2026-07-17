<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasDivisionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if the user has a job division
        if (!$user->jobDivision && $user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Kamu belum memiliki divisi. Silahkan hubungi administrator.');
        }

        return $next($request);
    }
}
