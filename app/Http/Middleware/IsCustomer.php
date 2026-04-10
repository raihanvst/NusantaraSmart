<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    public function handle(Request $request,    Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah customer
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            // Kalau bukan customer, tendang ke halaman utama
            return redirect('/')->with('error', 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}