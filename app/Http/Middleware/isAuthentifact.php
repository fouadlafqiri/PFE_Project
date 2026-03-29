<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAuthentifact
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Check if user is logged in AND is admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login')
                           ->with('error', 'Accès refusé. Admins seulement.');
        }

        return $next($request);
    }
}
