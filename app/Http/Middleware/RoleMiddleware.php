<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login?
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta di Route?
        // Admin bisa mengakses semua fitur, skip pengecekan role
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== $role) {
            // Jika role tidak cocok dan bukan admin, tendang keluar (403 Forbidden)
            abort(403, 'AKSES DITOLAK: Anda bukan ' . ucfirst($role));
        }
        if (Auth::user()->status !== 'active') {
            // Jika status tidak aktif, tendang keluar (403 Forbidden)
            abort(403, 'AKSES DITOLAK: Akun Anda tidak aktif.');
        }

        // 3. Jika lolos, silakan lanjut
        return $next($request);
    }
}
