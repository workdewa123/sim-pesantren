<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    // Contoh penerapan di showLogin() milik AuthController.php
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role === 'pengawas' || $user->role === 'pencatat') {
                return redirect()->to('/admin/pelanggaran');
            }
            
            if ($user->role === 'bendahara') {
                return redirect()->to('/admin/keuangan/dashboard');
            }

            if ($user->role === 'staf_media') {
                return redirect()->to('/dashboard-media');
            }

            if ($user->role === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
        }

        $profil = \App\Models\ProfilPesantren::first(); 
        return view('auth.login', compact('profil'));
    }
        // Memproses data login
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
            
            // Perbaikan total menggunakan kolom role dari database
            if ($user->role === 'pengawas' || $user->role === 'pencatat') {
                return redirect()->to('/admin/pelanggaran');
            }

            if ($user->role === 'bendahara') {
                return redirect()->to('/admin/keuangan/dashboard');
            }

            if ($user->role === 'staf_media') {
                return redirect()->to('/dashboard-media');
            }

            if ($user->role === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}