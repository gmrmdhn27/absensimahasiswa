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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Cek apakah role user ada di dalam daftar roles yang diizinkan
        if (!in_array($user->role, $roles)) {

            // Logika redirect berdasarkan role user yang tidak diizinkan
            if ($user->role === 'mahasiswa') {
                return redirect('/mahasiswa/dashboard')->with('error', 'Akses Ditolak.');
            } elseif ($user->role === 'dosen') {
                return redirect('/dosen/dashboard')->with('error', 'Akses Ditolak.');
            }

            // Default jika role tidak dikenali atau ditolak
            return redirect('/')->with('error', 'Akses Ditolak.');
        }

        return $next($request);
    }
}
