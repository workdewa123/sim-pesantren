<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPerusahaan;
use App\Models\Kegiatan;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data profil perusahaan baris pertama
        $profil = ProfilPerusahaan::first();
        
        // Ambil 3 kegiatan terbaru untuk ditampilkan di section berita
        $kegiatan = Kegiatan::orderBy('tanggal_kegiatan', 'desc')->take(3)->get();

        return view('landing.index', compact('profil'));

        // , 'kegiatan', 'totalSantri'
    }

    public function detailKegiatan($slug)
    {
        $profil = ProfilPerusahaan::first();
        $artikel = Kegiatan::where('slug', $slug)->firstOrFail();
        
        return view('landing.detail_kegiatan', compact('profil', 'artikel'));
    }
}