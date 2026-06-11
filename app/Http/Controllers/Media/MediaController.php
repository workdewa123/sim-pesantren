<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilPesantren;
use App\Models\KegiatanPesantren;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index()
    {
        $totalKegiatan = KegiatanPesantren::count();
        return view('media.dashboard', compact('totalKegiatan'));
    }

    // ==========================================
    // ⚙️ PENGELOLAAN PROFIL PESANTREN
    // ==========================================
    public function editProfil()
    {
        // Ambil data profil atau buat instansiasi kosong jika belum pernah diisi
        $profil = ProfilPesantren::first() ?? new ProfilPesantren();
        return view('media.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $profil = ProfilPesantren::first() ?? new ProfilPesantren();

        // 1. Definisikan aturan validasi dengan batas max 2048 KB (2 MB)
        $rules = [
            'nama_pesantren' => 'required|string|max:255',
            'sejarah_singkat' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'alamat' => 'required',
            'whatsapp_kontak' => 'required|numeric',
            'logo_pesantren' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // <-- Diubah ke 2048
        ];

        // 2. Buat pesan error kustom dalam Bahasa Indonesia
        $messages = [
            'logo_pesantren.image' => 'File yang diunggah harus berupa gambar.',
            'logo_pesantren.mimes' => 'Format gambar harus berupa jpeg, png, atau jpg.',
            'logo_pesantren.max'   => 'Ukuran foto logo terlalu besar! Maksimal ukuran yang diperbolehkan adalah 2 MB (2048 KB).',
        ];

        // Jalankan validasi dengan pesan kustom
        $request->validate($rules, $messages);

        // Pemetaan data secara manual
        $profil->nama_pesantren = $request->nama_pesantren;
        $profil->sejarah_singkat = $request->sejarah_singkat;
        $profil->visi = $request->visi;
        $profil->misi = $request->misi;
        $profil->alamat = $request->alamat;
        $profil->whatsapp_kontak = $request->whatsapp_kontak;
        $profil->instagram_link = $request->instagram_link;
        $profil->facebook_link = $request->facebook_link;
        $profil->youtube_link = $request->youtube_link;

        // Logika Upload Logo
        if ($request->hasFile('logo_pesantren')) {
            if ($profil->logo_pesantren) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $profil->logo_pesantren);
            }
            $profil->logo_pesantren = $request->file('logo_pesantren')->store('assets/logo', 'public');
        }

        $profil->save();

        return redirect()->back()->with('success', 'Profil pondok pesantren berhasil diperbarui!');
    } 
   // ==========================================
    // 📰 PENGELOLAAN BERITA KEGIATAN (MODAL AJAX)
    // ==========================================
    public function indexKegiatan()
    {
        $kegiatan = KegiatanPesantren::orderBy('tanggal_kegiatan', 'desc')->paginate(10);
        return view('media.kegiatan.index', compact('kegiatan'));
    }

    public function storeKegiatan(Request $request)
    {
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|max:500',
            'konten_lengkap' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('assets/kegiatan', 'public');
        }

        KegiatanPesantren::create([
            'judul_kegiatan' => $request->judul_kegiatan,
            'slug' => Str::slug($request->judul_kegiatan) . '-' . time(),
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'konten_lengkap' => $request->konten_lengkap,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'foto_kegiatan' => $fotoPath,
            'penulis' => Auth::user()->name
        ]);

        return redirect()->back()->with('success', 'Kegiatan baru berhasil dipublikasikan!');
    }

    public function editKegiatan($id)
    {
        $kegiatan = KegiatanPesantren::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function updateKegiatan(Request $request, $id)
    {
        $kegiatan = KegiatanPesantren::findOrFail($id);

        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|max:500',
            'konten_lengkap' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $kegiatan->judul_kegiatan = $request->judul_kegiatan;
        $kegiatan->deskripsi_singkat = $request->deskripsi_singkat;
        $kegiatan->konten_lengkap = $request->konten_lengkap;
        $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;

        if ($request->hasFile('foto_kegiatan')) {
            if ($kegiatan->foto_kegiatan) {
                Storage::delete('public/' . $kegiatan->foto_kegiatan);
            }
            $kegiatan->foto_kegiatan = $request->file('foto_kegiatan')->store('assets/kegiatan', 'public');
        }

        $kegiatan->save();
        return redirect()->back()->with('success', 'Data kegiatan berhasil diubah!');
    }

    public function destroyKegiatan($id)
    {
        $kegiatan = KegiatanPesantren::findOrFail($id);
        if ($kegiatan->foto_kegiatan) {
            Storage::delete('public/' . $kegiatan->foto_kegiatan);
        }
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Dokumentasi kegiatan berhasil dihapus!');
    }
}