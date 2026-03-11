<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya harus admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // Kalau bukan admin, tendang ke halaman utama
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Kalau admin, silakan masuk
        return $next($request);
    }
}