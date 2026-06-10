<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil statistik data santri yang statusnya sudah 'aktif'
        $totalSantri = Santri::where('status_santri', 'aktif')->count();
        $totalMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'mukim')->count();
        $totalNonMukim = Santri::where('status_santri', 'aktif')->where('jenis_santri', 'non-mukim')->count();

        // Mengirimkan data statistik ke view dashboard
        return view('admin.dashboard', compact('totalSantri', 'totalMukim', 'totalNonMukim'));
    }

    // ==================== TAMBAHKAN FUNGSI BARU DI BAWAH INI ====================

    // 1. Menampilkan daftar calon santri yang berstatus 'pending'
    public function persetujuanPendaftaran()
    {
        $antreanSantri = Santri::where('status_santri', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.persetujuan.index', compact('antreanSantri'));
    }

    // 2. Menampilkan detail data calon santri dan pilihan ploting kelas
    public function detailPersetujuan($id)
    {
        $santri = Santri::findOrFail($id);
        $daftarKelas = Kelas::all(); // Mengambil semua opsi kelas untuk di-ploting

        return view('admin.persetujuan.detail', compact('santri', 'daftarKelas'));
    }

    // 3. Memproses persetujuan: Mengubah status menjadi aktif dan menyimpan ploting kelas
    public function prosesSetuju(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $santri = Santri::findOrFail($id);
        
        // Update data santri menjadi aktif dan pasang kelasnya
        $santri->update([
            'status_santri' => 'aktif',
            'kelas_id'      => $request->kelas_id
        ]);

        return redirect()->route('admin.persetujuan.index')->with('success', 'Santri bernama ' . $santri->nama_santri . ' berhasil disetujui dan statusnya kini aktif!');
    }
}