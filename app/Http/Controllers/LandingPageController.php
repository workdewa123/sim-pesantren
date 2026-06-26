<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPesantren;
use App\Models\KegiatanPesantren;
use App\Models\Santri; // Opsional jika Anda sudah punya model Santri untuk hitung otomatis
use App\Models\Masyayikh; // Model untuk tokoh masyayikh

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data profil pesantren baris pertama
        $profil = ProfilPesantren::first();
        
        // PERBAIKAN: Naikkan limit take(3) menjadi take(10) atau hapus batasan agar bisa scroll ke samping
        $kegiatan = KegiatanPesantren::orderBy('tanggal_kegiatan', 'desc')->take(10)->get();
        
        $masyayikh = Masyayikh::orderBy('id', 'asc')->get();
        
        // Fitur inovasi: Hitung otomatis jumlah santri aktif dari database jika tabelnya ada
        $totalSantri = 0;
        if (class_exists('App\Models\Santri')) {
            $totalSantri = \App\Models\Santri::count(); 
        }

        return view('landing.index', compact('profil', 'kegiatan', "masyayikh", 'totalSantri'));
    }
    public function detailKegiatan($slug)
    {
        $profil = ProfilPesantren::first();
        $artikel = KegiatanPesantren::where('slug', $slug)->firstOrFail();
        
        return view('landing.detail_kegiatan', compact('profil', 'artikel'));
    }

    // <-- 4. TAMBAHKAN FUNGSI BARU UNTUK HALAMAN PROFIL BIOGRAFI TOKOH
    public function detailMasyayikh($slug)
    {
        $profil = ProfilPesantren::first();
        $tokoh = Masyayikh::where('slug', $slug)->firstOrFail();
        return view('landing.detail_masyayikh', compact('profil', 'tokoh'));
    }
}