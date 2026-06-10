<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard'); // Idealnya diarahkan ke dashboard masing-masing jika sudah login
        }
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // 1. Logika Otomatis untuk Pengawas & Pencatat
            if (str_contains($user->email, 'pengawas') || str_contains($user->email, 'pencatat')) {
                if (!$user->hasRole('pengawas', 'pencatat')) {
                    $user->assignRole('pengawas', 'pencatat');
                }
                return redirect()->to('/admin/pelanggaran');
            }

            // 🌟 2. TAMBAHKAN LOGIKA BARU INI KHUSUS UNTUK BENDAHARA
            if (str_contains($user->email, 'bendahara')) {
                // Pastikan role bendahara terpasang di database Spatie
                if (!$user->hasRole('bendahara')) {
                    $user->assignRole('bendahara');
                }
                // Alihkan langsung ke dasbor keuangan miliknya agar terhindar dari Eror 403
                return redirect()->route('admin.keuangan.dashboard');
            }

                // 🌟 3. LOGIKA BARU KHUSUS UNTUK STAF MEDIA
            if (str_contains($user->email, 'media')) {
                // Pastikan role staf_media terpasang di database Spatie
                if (!$user->hasRole('staf_media')) {
                    $user->assignRole('staf_media');
                }
                // Alihkan langsung ke dasbor media miliknya agar terhindar dari Eror
                return redirect()->route('media.dashboard');
            }

            // Jika admin utama atau role lain, arahkan ke dashboard bawaan
            return redirect()->intended('/admin/dashboard');
        }
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}