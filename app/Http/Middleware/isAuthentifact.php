<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAuthentifact
{
    // app/Http/Middleware/isAuthentifact.php
public function handle(Request $request, Closure $next)
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    if (Auth::check() && Auth::user()->role === 'livreur') {
        return redirect()->route('admin.orders.index');
    }

    return redirect()->route('home');
}
}
