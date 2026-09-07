<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Ensures user has a valid session role (admin or public).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = session('role');

        if (!$role || !in_array($role, ['admin', 'public'])) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
