<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use Carbon\Carbon;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya track halaman publik, bukan admin/pj/asset
        $path = $request->path();
        if (!str_starts_with($path, 'admin') && !str_starts_with($path, 'pj') && !str_starts_with($path, 'login')) {
            try {
                Pengunjung::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                    'halaman'    => '/' . $path,
                    'tanggal'    => Carbon::today(),
                ]);
            } catch (\Exception $e) {
                // silent fail agar tidak mengganggu halaman
            }
        }

        return $next($request);
    }
}