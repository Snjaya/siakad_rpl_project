<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->user()->role !== $role) {
            abort(403, 'Akses ditolak.'); // Membatasi hak akses berdasarkan peran [cite: 59, 41]
        }
        return $next($request);
    }
}
