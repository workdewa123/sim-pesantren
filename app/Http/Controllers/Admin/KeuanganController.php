<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Santri;
use App\Models\Kelas;   
use App\Models\PembayaranSpp;
use App\Models\IuranLain;
use App\Models\PembayaranIuranLain;
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

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_transaksi', $request->jenis);
        }

        $daftarKas = $query->orderBy('tanggal_transaksi', 'desc')->orderBy('id', 'desc')->paginate(10);

        // 🌟 TAMBAHAN: Ambil data master kategori agar modal create & edit bisa merendernya
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();

        // 🌟 SINKRONKAN: Kirim $daftarKas DAN $kategoris ke view
        return view('admin.keuangan.kas.index', compact('daftarKas', 'kategoris'));
    }

    public function updateKas(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'kategori'          => 'required|string|max:100',
            'nominal'           => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string',
        ]);

        $kas = Keuangan::findOrFail($id);
        $kas->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_transaksi'   => $request->jenis_transaksi,
            'kategori'          => $request->kategori,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
            'nama_bendahara'    => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Catatan transaksi kas berhasil diperbarui!');
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

    public function getSantriByKelas($kelas_id)
    {
        // Mengambil santri berstatus aktif berdasarkan pilihan dropdown kelas
        $santri = Santri::where('kelas_id', $kelas_id)
                        ->where('status_santri', 'aktif')
                        ->get(['id', 'nama_santri', 'pilihan_biaya', 'jenis_santri']);
        return response()->json($santri);
    }

    // --- PENGELOLA KATEGORI ---
    public function indexKategori()
    {
        $kategoris = Kategori::orderBy('tipe_kategori', 'asc')->get();
        
        // 🌟 DIUBAH: Mengarah ke folder admin.keuangan.kategori.index
        return view('admin.keuangan.kategori.index', compact('kategoris'));
    }

    // 🌟 TAMBAHAN: Fungsi Update Data Kategori Keuangan dari Modal Edit
    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'tipe_kategori' => 'required|in:pemasukan,pengeluaran',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'tipe_kategori' => $request->tipe_kategori,
        ]);

        return redirect()->back()->with('success', 'Master Kategori berhasil diperbarui!');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori',
            'tipe_kategori' => 'required|in:pemasukan,pengeluaran'
        ]);

        Kategori::create($request->all());
        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function destroyKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
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

    // =========================================================================
    // 🧑‍🎓 3. SUB-MODUL PEMBAYARAN SYAHRIYAH / SPP
    // =========================================================================
    public function indexSpp(Request $request)
    {
        $query = PembayaranSpp::with('santri');

        if ($request->filled('search')) {
            $query->whereHas('santri', function($q) use ($request) {
                $q->where('nama_santri', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $daftarSpp = $query->orderBy('id', 'desc')->paginate(15);
        $daftarKelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('admin.keuangan.spp.index', compact('daftarSpp', 'daftarKelas'));
    }

    public function storePembayaranSpp(Request $request)
    {
        $request->validate([
            'santri_id'      => 'required|exists:santri,id',
            'bulan'          => 'required|integer|between:1,12',
            'tahun'          => 'required|integer',
            'tanggal_bayar'  => 'required|date',
            'nama_bendahara' => 'nullable|string',
        ]);

        $santri = Santri::findOrFail($request->santri_id);

        // Cek duplikasi tagihan/pembayaran pada periode yang sama
        $exist = PembayaranSpp::where('santri_id', $request->santri_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($exist) {
            return redirect()->back()->with('error', 'Gagal! Pembayaran santri ini pada periode bulan/tahun tersebut sudah terdaftar.');
        }

        // Simpan data iuran baru ke database
        PembayaranSpp::create([
            'santri_id'         => $request->santri_id,
            'bulan'             => $request->bulan,
            'tahun'             => $request->tahun,
            'nominal_bayar'     => $santri->pilihan_biaya,
            'status_pembayaran' => 'Lunas',
            'tanggal_bayar'     => $request->tanggal_bayar,
            'nama_bendahara'    => $request->nama_bendahara ?? (Auth::user()->name ?? 'Bendahara'),
        ]);

        // Otomatis masukkan ke Buku Kas Umum sebagai pemasukan operasional pesantren
        $bulanHijriyah = [1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'];
        $namaBulan = $bulanHijriyah[$request->bulan] ?? $request->bulan;

        Keuangan::create([
            'tanggal_transaksi' => $request->tanggal_bayar,
            'jenis_transaksi'   => 'pemasukan',
            'kategori'          => 'SPP Santri',
            'nominal'           => $santri->pilihan_biaya,
            'keterangan'        => "Pembayaran Syahriyah SPP Santri a.n {$santri->nama_santri} (Bulan {$namaBulan} {$request->tahun} H)",
            'nama_bendahara'    => $request->nama_bendahara ?? (Auth::user()->name ?? 'Bendahara'),
        ]);

        return redirect()->route('admin.keuangan.spp.index')->with('success', 'Iuran Syahriyah santri berhasil dibukukan dan disinkronkan ke Kas Umum.');
    }

    public function updateSpp(Request $request, $id)
    {
        $request->validate([
            'bulan'             => 'required|integer|between:1,12',
            'tahun'             => 'required|integer',
            'nominal_bayar'     => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas',
            'tanggal_bayar'     => 'nullable|date',
            'nama_bendahara'    => 'nullable|string',
        ]);

        $spp = PembayaranSpp::findOrFail($id);
        
        // Update data SPP berdasarkan kiriman formulir penyesuaian tanggal kalender masehi
        $spp->update([
            'bulan'             => $request->bulan,
            'tahun'             => $request->tahun,
            'nominal_bayar'     => $request->nominal_bayar,
            'status_pembayaran' => $request->status_pembayaran,
            'tanggal_bayar'     => $request->status_pembayaran == 'Lunas' ? ($request->tanggal_bayar ?? now()->format('Y-m-d')) : null,
            'nama_bendahara'    => $request->nama_bendahara,
        ]);

        return redirect()->route('admin.keuangan.spp.index')->with('success', 'Catatan iuran Syahriyah berhasil diperbarui.');
    }

    public function destroySpp($id)
    {
        $spp = PembayaranSpp::findOrFail($id);
        $spp->delete();

        return redirect()->route('admin.keuangan.spp.index')->with('success', 'Catatan iuran Syahriyah santri berhasil dihapus dari sistem secara permanen.');
    }

    // =========================================================================
    // 🌟 FITUR TAMBAHAN: IURAN NON-SPP / LAIN-LAIN
    // =========================================================================

    // 1. Menyimpan Master Jenis Iuran Baru (Misal: Renovasi Musholla)
    public function storeIuranLain(Request $request)
    {
        $request->validate([
            'nama_iuran'     => 'required|string|max:255',
            'tahun_hijriyah' => 'required|integer'
        ]);

        IuranLain::create([
            'nama_iuran'     => strtoupper($request->nama_iuran),
            'tahun_hijriyah' => $request->tahun_hijriyah
        ]);

        return redirect()->back()->with('success', 'Kategori Iuran Lain-lain berhasil ditambahkan!');
    }

    // 2. Mencatat Transaksi Pembayaran Iuran Santri & Otomatis Masuk Buku Kas Besar
    public function storePembayaranIuranLain(Request $request)
    {
        $request->validate([
            'santri_id'     => 'required|exists:santri,id',
            'iuran_lain_id' => 'required|exists:iuran_lain,id',
            'nominal_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // Ambil data santri dan jenis iuran untuk keperluan catatan kas
            $santri = Santri::findOrFail($request->santri_id);
            $iuran  = IuranLain::findOrFail($request->iuran_lain_id);

            // 1. Simpan ke tabel pembayaran_iuran_lain
            PembayaranIuranLain::create([
                'santri_id'         => $request->santri_id,
                'iuran_lain_id'     => $request->iuran_lain_id,
                'status_pembayaran' => 'Lunas',
                'tanggal_bayar'     => $request->tanggal_bayar,
                'nama_bendahara'    => Auth::user()->name ?? 'Bendahara'
            ]);

            // 2. OTOMATIS BUKUKAN KE BUKU KAS BESAR (Tabel keuangans)
            // Cari Kategori ID untuk "Pemasukan" atau sesuaikan dengan sistem Anda
            Keuangan::create([
                'tanggal_transaksi' => $request->tanggal_bayar,
                'jenis_transaksi'   => 'pemasukan',
                'kategori'          => 'Iuran Santri',
                'nominal'           => $request->nominal_bayar,
                'metode_pembayaran' => 'cash',
                'keterangan'        => "PEMBAYARAN " . $iuran->nama_iuran . " A.N " . strtoupper($santri->nama_santri),
                'nama_bendahara'    => Auth::user()->name ?? 'Bendahara'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran iuran berhasil dibukukan ke Kas Besar!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // Ubah dari private ke public, dan tangkap data menggunakan Request
    public function exportMatriksExcel(Request $request)
    {
        // Validasi input tahun hijriyah yang dikirim oleh form
        $request->validate([
            'tahun_hijriyah' => 'required|integer'
        ]);

        $tahun = $request->tahun_hijriyah;

        // Urutan bulan hijriyah spesifik rekap iuran pesantren
        $urutanBulan = [
            10 => 'SYAWAL', 11 => "DZULQO'DAH", 12 => 'DZULHIJJAH', 
            1 => 'MUHAROM', 2 => 'SAFAR', 3 => "ROBI'UL AWAL", 
            4 => "ROBI'UL AKHIR", 5 => 'JUMADIL AWAL', 6 => 'JUMADIL AKHIR', 
            7 => 'RAJAB', 8 => "SYA'BAN", 9 => 'RAMADHAN'
        ];

        // Ambil data santri aktif
        $santriMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'mukim')->orderBy('nama_santri', 'asc')->get();
        $santriNonMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'non-mukim')->orderBy('nama_santri', 'asc')->get();

        // Tarik data seluruh riwayat pembayaran SPP pada tahun hijriyah tersebut
        $pembayaran = PembayaranSpp::where('tahun', $tahun)->get()->groupBy('santri_id');

        $namaFile = "REKAP_SPP_SANTRI_" . $tahun . "H.xls";

        // 🌟 QUERY TAMBAHAN: Ambil Program Iuran Lain-lain pada tahun tersebut
        $daftarIuranLain = IuranLain::where('tahun_hijriyah', $tahun)->orderBy('id', 'asc')->get();
        
        // Ambil histori pembayarannya dan kumpulkan berdasarkan santri_id
        $pembayaranIuranLain = PembayaranIuranLain::whereIn('iuran_lain_id', $daftarIuranLain->pluck('id'))
                                ->get()
                                ->groupBy('santri_id');

        // Return view matriks dengan header manipulasi excel native spreadsheet
        return response()->view('admin.keuangan.spp.laporan_matriks_excel', [
            'tahun'           => $tahun,
            'urutanBulan'     => $urutanBulan,
            'santriMukim'     => $santriMukim,
            'santriNonMukim'  => $santriNonMukim,
            'pembayaran'      => $pembayaran,
            'daftarIuranLain' => $daftarIuranLain,
            'pembayaranIuranLain' => $pembayaranIuranLain
        ])
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"');
    }

    // Tambahkan ini ke dalam KeuanganController.php
    public function previewMatriksHtml(Request $request)
    {
        $request->validate([
            'tahun_hijriyah' => 'required|integer'
        ]);

        $tahun = $request->tahun_hijriyah;

        $urutanBulan = [
            10 => 'SYAWAL', 11 => "DZULQO'DAH", 12 => 'DZULHIJJAH', 
            1 => 'MUHAROM', 2 => 'SAFAR', 3 => "ROBI'UL AWAL", 
            4 => "ROBI'UL AKHIR", 5 => 'JUMADIL AWAL', 6 => 'JUMADIL AKHIR', 
            7 => 'RAJAB', 8 => "SYA'BAN", 9 => 'RAMADHAN'
        ];

        $santriMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'mukim')->orderBy('nama_santri', 'asc')->get();
        $santriNonMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'non-mukim')->orderBy('nama_santri', 'asc')->get();

        $pembayaran = PembayaranSpp::where('tahun', $tahun)->get()->groupBy('santri_id');

        // 🌟 QUERY TAMBAHAN: Ambil Program Iuran Lain-lain pada tahun tersebut
        $daftarIuranLain = IuranLain::where('tahun_hijriyah', $tahun)->orderBy('id', 'asc')->get();
        
        // Ambil histori pembayarannya dan kumpulkan berdasarkan santri_id
        $pembayaranIuranLain = PembayaranIuranLain::whereIn('iuran_lain_id', $daftarIuranLain->pluck('id'))
                                ->get()
                                ->groupBy('santri_id');

        // Return view html preview biasa, tanpa header pengunduhan berkas excel
        return view('admin.keuangan.spp.laporan_matriks_preview', [
            'tahun'           => $tahun,
            'urutanBulan'     => $urutanBulan,
            'santriMukim'     => $santriMukim,
            'santriNonMukim'  => $santriNonMukim,
            'pembayaran'      => $pembayaran,
            'daftarIuranLain' => $daftarIuranLain,
            'pembayaranIuranLain' => $pembayaranIuranLain
        ]);
    }
}