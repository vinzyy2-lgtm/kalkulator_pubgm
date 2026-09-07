<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Hanya admin yang boleh akses.
     * Non-admin diarahkan ke halaman login admin yang tersembunyi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin.');
        }

        return $next($request);
    }
}
