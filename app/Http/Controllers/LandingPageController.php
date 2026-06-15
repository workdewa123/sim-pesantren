<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPerusahaan;
use App\Models\Kegiatan;
use App\Models\Card;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data profil perusahaan baris pertama
        $profil = ProfilPerusahaan::first();
        
        // Ambil 3 kegiatan terbaru untuk ditampilkan di section berita
        $card = card::all();

        return view('landing.index', compact('profil', 'card'));
    }

    public function detailCard($id)
    {
        $profil = ProfilPerusahaan::first();
        $card = card::where('id')->firstOrFail();
        
        return view('landing.detail_kegiatan', compact('profil', 'card'));
    }
}