<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah sudah login [cite: 517]
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role sesuai (admin atau penanggungjawab) [cite: 483]
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}