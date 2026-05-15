<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Pastikan file view ini ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input sesuai kebutuhan form kamu
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        // 2. Proses Percobaan Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. Pengalihan berdasarkan Role (Sesuai web.php kamu)
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin, ' . $user->name);
            } elseif ($user->role === 'penanggungjawab') {
                return redirect()->route('pj.dashboard')->with('success', 'Selamat datang, ' . $user->name);
            }

            // Jika role tidak dikenal, lempar ke beranda
            return redirect('/');
        }

        // 4. Jika gagal, balikkan ke login dengan pesan error merah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}