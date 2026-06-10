<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\Santri;

class PendaftaranController extends Controller
{
    // 1. Menampilkan halaman pengelolaan link pendaftaran (Khusus Admin)
    public function index()
    {
        $token = Cache::remember('pendaftaran_token', now()->addDays(7), function () {
            return Str::random(32);
        });

        $registrationUrl = route('pendaftaran.form', ['token' => $token]);

        return view('admin.pendaftaran.link', compact('registrationUrl'));
    }

    // 2. Fitur untuk memperbarui token pendaftaran secara berkala (Khusus Admin)
    public function refreshToken()
    {
        Cache::put('pendaftaran_token', Str::random(32), now()->addDays(7));
        return back()->with('success', 'Tautan pendaftaran yang baru berhasil dibuat!');
    }

    // ==================== TAMBAHKAN FUNGSI BARU DI BAWAH INI ====================

    // 3. Menampilkan Formulir Pendaftaran Digital ke Wali Santri (Publik)
    public function showForm($token)
    {
        // Validasi apakah token yang diakses wali santri sama dengan token aktif di sistem
        $activeToken = Cache::get('pendaftaran_token');

        if (!$activeToken || $activeToken !== $token) {
            abort(403, 'Tautan pendaftaran ini sudah tidak berlaku atau kadaluwarsa. Silakan hubungi pihak pesantren.');
        }

        return view('pendaftaran.form', compact('token'));
    }

    // 4. Memproses dan Menyimpan Data Pendaftaran dari Wali Santri (Publik)
    // 4. Memproses dan Menyimpan Data Pendaftaran dari Wali Santri (Publik)
public function storeForm(Request $request, $token)
    {
        $activeToken = Cache::get('pendaftaran_token');

        if (!$activeToken || $activeToken !== $token) {
            abort(403, 'Tautan pendaftaran kadaluwarsa.');
        }

        // 1. SESUAIKAN: Ubah 'pilihan_biaya' menjadi 'kesanggupan_biaya' sesuai nama input HTML
        $request->validate([
            'nama_santri' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_santri' => 'required|string',
            'tahun_masuk' => 'required|integer',
            'jenis_santri' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'alamat_orang_tua' => 'required|string',
            'no_hp_wali' => 'required|numeric',
            'kesanggupan_biaya' => 'required|numeric', // <-- Diubah di sini
            'file_kk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file_akte' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload File Berkas Dokumen
        $pathKK = $request->file('file_kk')->store('assets/berkas_pendaftaran', 'public');
        $pathAkte = $request->file('file_akte')->store('assets/berkas_pendaftaran', 'public');

        // 2. SESUAIKAN: Ambil nilainya menggunakan $request->kesanggupan_biaya
        $santri = Santri::create([
            'nama_santri' => $request->nama_santri,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat_santri' => $request->alamat_santri,
            'tahun_masuk' => $request->tahun_masuk,
            'jenis_santri' => $request->jenis_santri,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'alamat_orang_tua' => $request->alamat_orang_tua,
            'no_hp_wali' => $request->no_hp_wali,
            'pilihan_biaya' => $request->kesanggupan_biaya, // <-- Diambil dari 'kesanggupan_biaya' untuk disimpan ke kolom DB 'pilihan_biaya'
            'file_kk' => $pathKK,
            'file_akte' => $pathAkte,
            'status_santri' => 'pending',
        ]);

        return redirect()->route('pendaftaran.sukses', ['id' => $santri->id]);
    }
    // 5. Menampilkan Halaman Sukses Pendaftaran (Publik)
    public function sukses($id)
    {
        $santri = Santri::findOrFail($id);
        return view('pendaftaran.sukses', compact('santri'));
    }

    // 6. Generate Formulir PDF untuk Diunduh (Publik)
    public function cetakPdf($id)
    {
        $santri = Santri::findOrFail($id);
        
        // Membaca view khusus cetak cetakan kertas
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pendaftaran.cetak_pdf', compact('santri'));
        
        // Mengunduh file PDF dengan nama otomatis sesuai nama santri
        return $pdf->download('Formulir_Pendaftaran_' . Str::slug($santri->nama_santri) . '.pdf');
    }
}