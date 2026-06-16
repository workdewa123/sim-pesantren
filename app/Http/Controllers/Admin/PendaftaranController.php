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
    // GANTI METHOD showForm PADA PendaftaranController.php MENJADI SEPERTI INI:
    public function showForm($token)
    {
        $activeToken = Cache::get('pendaftaran_token');
        if (!$activeToken || $activeToken !== $token) {
            abort(403, 'Tautan pendaftaran ini sudah tidak berlaku atau kadaluwarsa.');
        }

        $configBiaya = \DB::table('pengaturan_biaya')->orderBy('id')->get();
        
        // TAMBAHKAN BARIS INI: Ambil semua data komponen rincian pendaftaran awal
        $rincianBiaya = \DB::table('rincian_biaya')->get();

        return view('pendaftaran.form', compact('token', 'configBiaya', 'rincianBiaya'));
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
// CARI METHOD sukses($id) DI PendaftaranController.php DAN GANTI MENJADI SEPERTI INI:
    public function sukses($id)
    {
        $santri = Santri::findOrFail($id);

        // 1. Ambil rincian biaya dari database yang sesuai dengan jenis santri
        $rincianBiaya = \DB::table('rincian_biaya')
            ->whereIn('jenis_santri', ['semua', $santri->jenis_santri])
            ->get();

        // 2. Hitung total akumulasi (Rincian Biaya Tetap + Pilihan Iuran Bulanan)
        $totalBiaya = $rincianBiaya->sum('nominal') + (int)$santri->pilihan_biaya;

        return view('pendaftaran.sukses', compact('santri', 'rincianBiaya', 'totalBiaya'));
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

    // Tambahkan fungsi ini di dalam PendaftaranController.php paling bawah
    public function indexBiaya()
    {
        $biayaMukim = \DB::table('pengaturan_biaya')->where('jenis_santri', 'mukim')->orderBy('opsi_ke')->get();
        $biayaNonMukim = \DB::table('pengaturan_biaya')->where('jenis_santri', 'non-mukim')->orderBy('opsi_ke')->get();

        return view('admin.pendaftaran.biaya', compact('biayaMukim', 'biayaNonMukim'));
    }

    public function updateBiaya(Request $request)
    {
        $request->validate([
            'biaya' => 'required|array'
        ]);

        foreach ($request->biaya as $id => $nominal) {
            // Hilangkan titik jika admin input menggunakan pemisah ribuan
            $nominalBersih = (int) str_replace('.', '', $nominal);
            
            \DB::table('pengaturan_biaya')->where('id', $id)->update([
                'nominal' => $nominalBersih,
                'teks_tampilan' => 'Rp ' . number_format($nominalBersih, 0, ',', '.'),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'Konfigurasi nominal biaya pendaftaran santri berhasil diperbarui!');
    }

    // TAMBAHKAN DI BAGIAN PALING BAWAH FILE PendaftaranController.php

    public function indexRincianBiaya()
    {
        $semuaRincian = \DB::table('rincian_biaya')->orderBy('jenis_santri')->get();
        return view('admin.pendaftaran.rincian_index', compact('semuaRincian'));
    }

    public function storeRincianBiaya(Request $request)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:150',
            'jenis_santri'  => 'required|in:semua,mukim,non-mukim',
            'nominal'       => 'required|numeric|min:0'
        ]);

        \DB::table('rincian_biaya')->insert([
            'nama_komponen' => $request->nama_komponen,
            'jenis_santri'  => $request->jenis_santri,
            'nominal'       => $request->nominal,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        return back()->with('success', 'Rincian komponen biaya pendaftaran baru berhasil ditambahkan!');
    }

    public function updateRincianBiaya(Request $request, $id)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:150',
            'jenis_santri'  => 'required|in:semua,mukim,non-mukim',
            'nominal'       => 'required|numeric|min:0'
        ]);

        \DB::table('rincian_biaya')->where('id', $id)->update([
            'nama_komponen' => $request->nama_komponen,
            'jenis_santri'  => $request->jenis_santri,
            'nominal'       => $request->nominal,
            'updated_at'    => now()
        ]);

        return back()->with('success', 'Data komponen biaya pendaftaran berhasil diperbarui!');
    }

    public function destroyRincianBiaya($id)
    {
        \DB::table('rincian_biaya')->where('id', $id)->delete();
        return back()->with('success', 'Komponen rincian biaya pendaftaran berhasil dihapus dari sistem.');
    }

    // TAMBAHKAN METHOD INI DI PALING BAWAH FILE PendaftaranController.php
    public function cetakBiayaPdf($id)
    {
        $santri = Santri::findOrFail($id);
        
        $rincianBiaya = \DB::table('rincian_biaya')
            ->whereIn('jenis_santri', ['semua', $santri->jenis_santri])
            ->get();

        $totalBiaya = $rincianBiaya->sum('nominal') + (int)$santri->pilihan_biaya;

        // Load view khusus cetakan PDF rincian biaya
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pendaftaran.cetak_biaya_pdf', compact('santri', 'rincianBiaya', 'totalBiaya'));
        
        return $pdf->download('Rincian_Biaya_Pendaftaran_' . Str::slug($santri->nama_santri) . '.pdf');
    }
}