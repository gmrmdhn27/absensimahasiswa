<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        // Mengarahkan ke view login yang sudah Anda buat
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Lanjutkan dengan logika otentikasi dan redirect role Anda
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();

                $role = Auth::user()->role;
                switch ($role) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                    break;
                case 'dosen':
                    // Gunakan route dosen.dashboard yang sudah kita definisikan
                    return redirect()->intended(route('dosen.dashboard'));
                    break;
                case 'mahasiswa':
                    // Gunakan route mahasiswa.dashboard yang sudah kita definisikan
                    return redirect()->intended(route('mahasiswa.dashboard'));
                    break;
                default:
                    // Pengalihan default jika role tidak terdefinisi
                    return redirect('/');
            }
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak cocok.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Mengarahkan kembali ke halaman login
        return redirect('/login');
    }
}
