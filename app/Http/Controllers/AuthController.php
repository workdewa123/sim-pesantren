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
        $profil = \App\Models\ProfilPesantren::first(); 

    // Kirim variabel $profil ke dalam view
    return view('auth.login', compact('profil'));
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
        
        // 1. Jika Pengawas atau Pencatat
        if (str_contains($user->email, 'pengawas') || str_contains($user->email, 'pencatat')) {
            return redirect()->to('/admin/pelanggaran');
        }

        // 2. Jika Bendahara
        if (str_contains($user->email, 'bendahara')) {
            return redirect()->to('/admin/keuangan/dashboard'); // Menggunakan URL langsung agar aman
        }

        // 3. Jika Staf Media
        if (str_contains($user->email, 'media')) {
            return redirect()->to('/dashboard-media'); // Menggunakan URL langsung sesuai prefix web.php
        }

        // 4. Jika Admin Utama (Gunakan URL langsung ke dasbor admin Anda)
        return redirect()->to('/admin/dashboard'); 
    }

    // Jika login gagal, kembalikan ke halaman login dengan pesan error
    return back()->withErrors([
        'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
    ])->onlyInput('email');
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