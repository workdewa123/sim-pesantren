<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Keuangan;
use App\Models\PembayaranSpp;
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class KeuanganController extends Controller
{
// =========================================================================
    // 📊 1. DASBOR KEUANGAN
    // =========================================================================
    public function dashboard()
    {
        // Hitung akumulasi dari Buku Kas Besar (keuangans)
        $totalPemasukan = Keuangan::where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        $saldoSisa = $totalPemasukan - $totalPengeluaran;

        // Ambil info tunggakan iuran santri saat ini
        $totalTunggakanSpp = PembayaranSpp::where('status_pembayaran', 'Belum Lunas')->count();

        // Riwayat 5 transaksi terakhir kas besar
        $transaksiTerakhir = Keuangan::orderBy('tanggal_transaksi', 'desc')->orderBy('id', 'desc')->limit(5)->get();

        // 📊 QUERY TAMBAHAN: Mengambil Tren Kas 6 Bulan Terakhir untuk Grafik
        $trenGrafik = Keuangan::select(
                DB::raw("DATE_FORMAT(tanggal_transaksi, '%Y-%m') as bulan"),
                DB::raw("SUM(CASE WHEN jenis_transaksi = 'pemasukan' THEN nominal ELSE 0 END) as total_masuk"),
                DB::raw("SUM(CASE WHEN jenis_transaksi = 'pengeluaran' THEN nominal ELSE 0 END) as total_keluar")
            )
            ->where('tanggal_transaksi', '>=', now()->subMonths(5)->startOfMonth()) // Ambil 6 bulan terakhir
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Persiapkan wadah array untuk Chart.js
        $labelBulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        // Daftar nama bulan dalam Bahasa Indonesia
        $namaBulanIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        foreach ($trenGrafik as $data) {
            $pecah = explode('-', $data->bulan); // Hasil: ['2026', '06']
            $bulanAngka = $pecah[1];
            $tahun = $pecah[0];
            
            $labelBulan[] = $namaBulanIndo[$bulanAngka] . ' ' . $tahun;
            $dataPemasukan[] = (int) $data->total_masuk;
            $dataPengeluaran[] = (int) $data->total_keluar;
        }

        // Jika data database masih kosong, berikan fallback bulan berjalan agar grafik tidak error/patah
        if (empty($labelBulan)) {
            $labelBulan = [$namaBulanIndo[date('m')] . ' ' . date('Y')];
            $dataPemasukan = [0];
            $dataPengeluaran = [0];
        }

        return view('admin.keuangan.dashboard', compact(
            'totalPemasukan', 'totalPengeluaran', 'saldoSisa', 'totalTunggakanSpp', 'transaksiTerakhir',
            'labelBulan', 'dataPemasukan', 'dataPengeluaran'
        ));
    }
    // =========================================================================
    // 💵 2. SUB-MODUL: BUKU KAS UMUM
    // =========================================================================
    public function indexKas(Request $request)
    {
        $query = Keuangan::query();

        // Fitur Pencarian & Filter Kategori
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_transaksi', $request->jenis);
        }

        $daftarKas = $query->orderBy('tanggal_transaksi', 'desc')->orderBy('id', 'desc')->paginate(10);

        return view('admin.keuangan.kas_index', compact('daftarKas'));
    }

    public function storeKas(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'kategori'          => 'required|string|max:100',
            'nominal'           => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string',
        ]);

        Keuangan::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_transaksi'   => $request->jenis_transaksi,
            'kategori'          => $request->kategori,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
            'nama_bendahara'    => Auth::user()->name, // Otomatis mengunci nama bendahara login
        ]);

        return redirect()->back()->with('success', 'Catatan transaksi kas besar berhasil disimpan!');
    }

    public function destroyKas($id)
    {
        $kas = Keuangan::findOrFail($id);
        $kas->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus dari pembukuan.');
    }

    // =========================================================================
    // 🧑‍🎓 3. SUB-MODUL: PEMBAYARAN IURAN SPP SANTRI
    // =========================================================================
    public function indexSpp(Request $request)
    {
        // Query menggabungkan iuran spp dengan data santri dan kelasnya
        $query = DB::table('pembayaran_spp')
            ->join('santri', 'pembayaran_spp.santri_id', '=', 'santri.id')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->select('pembayaran_spp.*', 'santri.nama_santri', 'kelas.nama_kelas');

        // Filter Pencarian Nama Santri
        if ($request->filled('search')) {
            $query->where('santri.nama_santri', 'like', '%' . $request->search . '%');
        }
        // Filter Berdasarkan Status Lunas / Belum Lunas
        if ($request->filled('status')) {
            $query->where('pembayaran_spp.status_pembayaran', $request->status);
        }
        // Filter Berdasarkan Bulan Tertentu
        if ($request->filled('bulan')) {
            $query->where('pembayaran_spp.bulan', $request->bulan);
        }

        $daftarSpp = $query->orderBy('pembayaran_spp.tahun', 'desc')
                           ->orderBy('pembayaran_spp.bulan', 'desc')
                           ->orderBy('santri.nama_santri', 'asc')
                           ->paginate(20);

        return view('admin.keuangan.spp_index', compact('daftarSpp'));
    }

    // 🌟 LOGIKA UTAMA SISTEM HYBRID 🌟
    public function prosesBayarSpp($id)
    {
        $spp = PembayaranSpp::findOrFail($id);

        if ($spp->status_pembayaran == 'Lunas') {
            return redirect()->back()->with('error', 'Tagihan ini sudah lunas sebelumnya.');
        }

        // Ambil nama santri untuk keperluan teks pencatatan kas besar
        $namaSantri = DB::table('santri')->where('id', $spp->santri_id)->value('nama_santri');

        // 1. Ubah status iuran santri menjadi Lunas
        $spp->update([
            'status_pembayaran' => 'Lunas',
            'tanggal_bayar'     => now()->toDateString(),
            'nama_bendahara'    => Auth::user()->name,
        ]);

        // 2. OTOMATISASI HYBRID: Langsung tembak data ke dalam Buku Kas Besar (Tabel keuangans)
        Keuangan::create([
            'tanggal_transaksi' => now()->toDateString(),
            'jenis_transaksi'   => 'pemasukan',
            'kategori'          => 'SPP Santri',
            'nominal'           => $spp->nominal_bayar,
            'keterangan'        => "Pembayaran SPP Bulanan atas nama {$namaSantri} (Bulan: {$spp->bulan}/{$spp->tahun})",
            'nama_bendahara'    => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', "Pembayaran SPP {$namaSantri} berhasil diproses dan masuk Kas Besar!");
    }

    // 🛠️ FITUR GENERATOR OTOMATIS: Membuat tagihan baru masal untuk bulan berjalan
    public function generateTagihanBulanan(Request $request)
    {
        $request->validate([
            'bulan'         => 'required|integer|between:1,12',
            'tahun'         => 'required|integer|min:2025',
            'nominal_spp'   => 'required|numeric|min:0',
        ]);

        // Ambil semua daftar santri yang statusnya masih aktif saja
        $santriAktif = DB::table('santri')->where('status_santri', 'aktif')->get();
        $jumlahTergenerate = 0;

        foreach ($santriAktif as $santri) {
            // Cek apakah data tagihan santri bersangkutan di bulan tersebut sudah ada atau belum
            $cekDataExist = PembayaranSpp::where('santri_id', $santri->id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->exists();

            if (!$cekDataExist) {
                PembayaranSpp::create([
                    'santri_id'         => $santri->id,
                    'bulan'             => $request->bulan,
                    'tahun'             => $request->tahun,
                    'nominal_bayar'     => $request->nominal_spp,
                    'status_pembayaran' => 'Belum Lunas',
                ]);
                $jumlahTergenerate++;
            }
        }

        return redirect()->back()->with('success', "Berhasil merilis {$jumlahTergenerate} data tagihan baru untuk bulan opsi opsi opsi {$request->bulan}/{$request->tahun}.");
    }

// =========================================================================
    // 🖨️ 4. UNDUH LAPORAN REKAPITULASI
    // =========================================================================
    
    // Fungsi Unduh Laporan PDF
    // Fungsi Unduh Laporan PDF Murni (.pdf)
    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        $dataLaporan = Keuangan::whereBetween('tanggal_transaksi', [$request->dari_tanggal, $request->sampai_tanggal])
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        $totalMasuk = $dataLaporan->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalKeluar = $dataLaporan->where('jenis_transaksi', 'pengeluaran')->sum('nominal');

        $namaFile = "Laporan-Kas-" . $request->dari_tanggal . "-sd-" . $request->sampai_tanggal . ".pdf";
        
        // Menggunakan DomPDF untuk merender view blade menjadi PDF murni sebelum diunduh
        $pdf = \Pdf::loadView('admin.keuangan.laporan_cetak', compact('dataLaporan', 'totalMasuk', 'totalKeluar', 'request'));
        
        // Langsung unduh otomatis berkasnya
        return $pdf->download($namaFile);
    }

    // Fungsi Unduh Laporan Excel
    // Fungsi Unduh Laporan Excel
// Fungsi Unduh Laporan Excel
    // Fungsi Unduh Laporan Excel - Menggunakan Driver Native Browser (Bebas Crash Vendor)
    public function exportExcel(Request $request)
    {
        $request->validate([
            'dari_tanggal'   => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal',
        ]);

        $dataLaporan = Keuangan::whereBetween('tanggal_transaksi', [$request->dari_tanggal, $request->sampai_tanggal])
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        $totalMasuk = $dataLaporan->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalKeluar = $dataLaporan->where('jenis_transaksi', 'pengeluaran')->sum('nominal');

        // Nama file output spreadsheet
        $namaFile = "Laporan-Kas-PPRA-" . $request->dari_tanggal . "-sd-" . $request->sampai_tanggal . ".xls";

        // Trik manipulasi Header HTTP untuk memaksa sistem operasi membukanya sebagai berkas Excel spreadsheet
        return response()->view('admin.keuangan.laporan_cetak', compact('dataLaporan', 'totalMasuk', 'totalKeluar', 'request'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->header('Cache-Control', 'max-age=0');
    }
}