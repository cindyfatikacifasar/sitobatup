<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenanggungJawabMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin','penanggung_jawab'])) {
            return redirect()->route('pj.login')->with('error', 'Akses ditolak.');
        }
        return $next($request);
    }
}