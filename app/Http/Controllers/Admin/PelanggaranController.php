<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    // 1. Halaman Dashboard Pelanggaran (Statistik & Grafik)
    public function dashboard()
    {
        $totalSantri = DB::table('santri')->count();
        $totalMukim = DB::table('santri')->where('jenis_santri', 'mukim')->count();
        $totalNonMukim = DB::table('santri')->where('jenis_santri', 'non-mukim')->count();
        
        $totalPelanggaranBulanIni = DB::table('pelanggaran')
            ->whereMonth('tanggal_pelanggaran', date('m'))
            ->whereYear('tanggal_pelanggaran', date('Y'))
            ->count();

        $grafikRaw = DB::table('pelanggaran')
            ->select(DB::raw("DATE_FORMAT(tanggal_pelanggaran, '%Y-%m') as bulan"), DB::raw('count(*) as total'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->limit(6)
            ->get();

        $labels = [];
        $chartData = [];
        
        foreach ($grafikRaw as $data) {
            $labels[] = date('F Y', strtotime($data->bulan . '-01'));
            $chartData[] = $data->total;
        }

        return view('admin.pelanggaran.dashboard', compact(
            'totalSantri', 'totalMukim', 'totalNonMukim', 'totalPelanggaranBulanIni', 'labels', 'chartData'
        ));
    }

    // 2. Halaman Index (Tabel Data Utama + Handler Filter & Search)
    public function index(Request $request)
    {
        // Dropdown data master kelas
        $daftarKelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        $query = DB::table('pelanggaran')
            ->join('santri', 'pelanggaran.santri_id', '=', 'santri.id')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->join('users', 'pelanggaran.user_id', '=', 'users.id')
            ->select(
                'pelanggaran.*', 
                'santri.nama_santri', 
                'santri.jenis_santri', 
                'kelas.nama_kelas', 
                'users.name as nama_petugas'
            );

        // Filter: Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $query->where('santri.nama_santri', 'like', '%' . $request->search . '%');
        }

        // Filter: Berdasarkan Ruang Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('santri.kelas_id', $request->kelas_id);
        }

        // PERBAIKAN LOGIKA: Filter Baru Berdasarkan Jenis Santri (Mukim / Non-Mukim)
        if ($request->has('jenis_santri') && $request->jenis_santri != '') {
            $query->where('santri.jenis_santri', $request->jenis_santri);
        }

        $daftarPelanggaran = $query->orderBy('pelanggaran.tanggal_pelanggaran', 'desc')->paginate(10);
        $daftarSantri = DB::table('santri')->where('status_santri', 'aktif')->orderBy('nama_santri', 'asc')->get();


        return view('admin.pelanggaran.index', compact('daftarPelanggaran', 'daftarKelas', 'daftarSantri'));
    }

    // 3. API JSON Endpoint untuk Kebutuhan Data Modal Detail
    public function getDetailSantri($santri_id)
    {
        $santri = DB::table('santri')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->where('santri.id', $santri_id)
            ->select('santri.*', 'kelas.nama_kelas')
            ->first();

        if (!$santri) {
            return response()->json(['error' => 'Data santri tidak ditemukan'], 404);
        }

        $riwayat = DB::table('pelanggaran')
            ->join('users', 'pelanggaran.user_id', '=', 'users.id')
            ->where('pelanggaran.santri_id', $santri_id)
            ->select('pelanggaran.*', 'users.name as nama_petugas')
            ->orderBy('pelanggaran.tanggal_pelanggaran', 'desc')
            ->get();

        return response()->json([
            'santri' => $santri,
            'riwayat' => $riwayat
        ]);
    }

    // 4. Form Menginput Pelanggaran Baru
    public function create()
    {
        // Cek ketat menggunakan kolom role database
        if (Auth::user()->role !== 'pencatat') {
            abort(403, 'Hanya petugas pencatat yang diizinkan mengakses halaman input.');
        }

        $daftarKelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $daftarSantri = DB::table('santri')->where('status_santri', 'aktif')->orderBy('nama_santri', 'asc')->get();

        return view('admin.pelanggaran.create', compact('daftarKelas', 'daftarSantri'));
    }
    // 5. Simpan Catatan Pelanggaran
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pencatat') {
            abort(403, 'Hanya petugas pencatat yang diizinkan.');
        }

        $request->validate([
            'santri_id'            => 'required',
            'tanggal_pelanggaran'  => 'required|date',
            'kategori_pelanggaran' => 'required|string',
            'deskripsi_pelanggaran'=> 'required|string',
        ]);

        DB::table('pelanggaran')->insert([
            'santri_id'            => $request->santri_id,
            'user_id'              => Auth::id(),
            'tanggal_pelanggaran'  => $request->tanggal_pelanggaran,
            'kategori_pelanggaran' => $request->kategori_pelanggaran,
            'deskripsi_pelanggaran'=> $request->deskripsi_pelanggaran,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        return redirect()->route('admin.pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil disimpan!');
    }

    // 6. Menghapus Catatan Data
    public function destroy($id)
    {
        DB::table('pelanggaran')->where('id', $id)->delete();
        return redirect()->route('admin.pelanggaran.index')->with('success', 'Catatan pelanggaran berhasil dihapus!');
    }

// ==========================================
    // API UNTUK MENGAMBIL SANTRI BERDASARKAN KELAS
    // ==========================================
    public function getSantriByKelas($kelas_id)
    {
        $santri = \DB::table('santri')
            ->where('kelas_id', $kelas_id)
            ->where('status_santri', 'aktif')
            ->orderBy('nama_santri', 'asc')
            ->select('id', 'nama_santri')
            ->get();

        return response()->json($santri);
    }
    
}