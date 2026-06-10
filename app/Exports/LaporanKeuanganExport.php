<?php

namespace App\Exports;

use App\Models\Keuangan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanKeuanganExport implements FromView, ShouldAutoSize
{
    protected $dari, $sampai;

    public function __construct($dari, $sampai) {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function view(): View
    {
        $dataLaporan = Keuangan::whereBetween('tanggal_transaksi', [$this->dari, $this->sampai])
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        $totalMasuk = $dataLaporan->where('jenis_transaksi', 'pemasukan')->sum('nominal');
        $totalKeluar = $dataLaporan->where('jenis_transaksi', 'pengeluaran')->sum('nominal');
        
        $request = (object)['dari_tanggal' => $this->dari, 'sampai_tanggal' => $this->sampai];

        return view('admin.keuangan.laporan_cetak', compact('dataLaporan', 'totalMasuk', 'totalKeluar', 'request'));
    }
}