<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\PembayaranSpp;
use App\Models\Keuangan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'bulan' => 'required|numeric|between:1,12',
            'tahun' => 'required|numeric',
            'metode_pembayaran' => 'required|in:cash,rekening',
        ]);

        // 1. Ambil data santri beserta relasi kelasnya
        $santri = Santri::with('kelas')->findOrFail($request->santri_id);

        // 2. Pastikan Kategori "Syahriyah" sudah ada di database, jika belum buat otomatis
        $kategori = Kategori::firstOrCreate(
            ['nama_kategori' => 'Syahriyah'],
            ['tipe_kategori' => 'pemasukan']
        );

        // 3. Gunakan Database Transaction agar jika salah satu insert gagal, semua di-rollback
        DB::beginTransaction();

        try {
            // Ambil nominal berdasarkan pilihan_biaya di data master santri
            $nominal = $santri->pilihan_biaya; 
            $namaBendahara = Auth::user()->name ?? 'Bendahara Kantor';

            // 4. Simpan ke tabel pembayaran_spp
            $spp = PembayaranSpp::create([
                'santri_id' => $santri->id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'nominal_bayar' => $nominal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'Lunas',
                'tanggal_bayar' => now(),
                'nama_bendahara' => $namaBendahara
            ]);

            // 5. Format teks keterangan sesuai permintaan Anda
            $namaKelas = $santri->kelas ? $santri->kelas->nama_kelas : 'Tanpa Kelas';
            $statusMukim = ucfirst($santri->jenis_santri); // Mukim / Non-mukim
            $daftarBulanHijriyah = [
                1 => 'Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir', 
                'Jumadil Awal', 'Jumadil Akhir', 'Rajab', 'Syaban', 
                'Ramadhan', 'Syawal', 'Dzulqaidah', 'Dzulhijjah'
            ];
            $bulanName = $daftarBulanHijriyah[$request->bulan];

            $keteranganOtomatis = "Pembayaran SPP Syahriyah bulan {$bulanName} {$request->tahun}. ";
            $keteranganOtomatis .= "Santri: {$santri->nama_santri} ({$namaKelas} - {$statusMukim})";

            // 6. Otomatis masukkan data transaksi ke Buku Kas (Tabel Keuangans)
            Keuangan::create([
                'tanggal_transaksi' => now(),
                'jenis_transaksi' => 'pemasukan',
                'kategori_id' => $kategori->id,
                'kategori' => $kategori->nama_kategori, // Backup text string
                'nominal' => $nominal,
                'metode_pembayaran' => $request->metode_pembayaran, // cash atau rekening
                'keterangan' => $keteranganOtomatis,
                'nama_bendahara' => $namaBendahara
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran Syahriyah berhasil disimpan dan dibukukan ke Kas Umum!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}