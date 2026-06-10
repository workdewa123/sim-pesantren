<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPesantren;
use App\Models\KegiatanPesantren;
use App\Models\Santri; // Opsional jika Anda sudah punya model Santri untuk hitung otomatis

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data profil pesantren baris pertama
        $profil = ProfilPesantren::first();
        
        // Ambil 3 kegiatan terbaru untuk ditampilkan di section berita
        $kegiatan = KegiatanPesantren::orderBy('tanggal_kegiatan', 'desc')->take(3)->get();
        
        // Fitur inovasi: Hitung otomatis jumlah santri aktif dari database jika tabelnya ada
        $totalSantri = 0;
        if (class_exists('App\Models\Santri')) {
            $totalSantri = \App\Models\Santri::count(); 
        }

        return view('landing.index', compact('profil', 'kegiatan', 'totalSantri'));
    }

    public function detailKegiatan($slug)
    {
        $profil = ProfilPesantren::first();
        $artikel = KegiatanPesantren::where('slug', $slug)->firstOrFail();
        
        return view('landing.detail_kegiatan', compact('profil', 'artikel'));
    }
}