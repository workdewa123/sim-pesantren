<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan Anda sudah menginstal paket dompdf dan menambahkan alias di config/app.php

class KelasController extends Controller
{
    // 1. Menampilkan Semua Data Kelas dengan Join ke Tabel Ustadz
    // 1. Menampilkan Semua Data Kelas dengan Join ke Tabel Ustadz beserta data Modal Create & Edit
    public function index()
    {
        // Mengambil data kelas untuk tabel utama
        $daftarKelas = \DB::table('kelas')
            ->leftJoin('ustadz', 'kelas.ustadz_id', '=', 'ustadz.id')
            ->select('kelas.*', 'ustadz.nama_ustadz')
            ->orderBy('kelas.created_at', 'desc')
            ->paginate(10);

        // Ambil data semua ustadz untuk keperluan dropdown di dalam modal Create & Edit
        $daftarUstadz = \DB::table('ustadz')->orderBy('nama_ustadz', 'asc')->get();

        // Kirim kedua variabel ke satu view index yang sama
        return view('admin.kelas.index', compact('daftarKelas', 'daftarUstadz'));
    }

    // 2. Menampilkan Form Tambah Kelas dengan Mengirimkan Daftar Ustadz
    public function create()
    {
        $daftarUstadz = \DB::table('ustadz')->orderBy('nama_ustadz', 'asc')->get();
        return view('admin.kelas.create', compact('daftarUstadz'));
    }

    // 3. Menyimpan Data Kelas Baru beserta Wali Kelas
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'ustadz_id'  => 'nullable|integer', // validasi ustadz_id boleh kosong jika belum ada wali
        ]);

        \DB::table('kelas')->insert([
            'nama_kelas' => $request->nama_kelas,
            'ustadz_id'  => $request->ustadz_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas baru berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Kelas dengan Data Wali Saat Ini
    public function edit($id)
    {
        $kelas = \DB::table('kelas')->where('id', $id)->first();
        if (!$kelas) abort(404);

        $daftarUstadz = \DB::table('ustadz')->orderBy('nama_ustadz', 'asc')->get();

        return view('admin.kelas.edit', compact('kelas', 'daftarUstadz'));
    }

    // 5. Memperbarui Data Kelas dan Wali Kelas
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'ustadz_id'  => 'nullable|integer',
        ]);

        \DB::table('kelas')->where('id', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'ustadz_id'  => $request->ustadz_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil diperbarui!');
    }

    // 6. Mencetak Form Absensi Kelas dalam Format PDF
    public function cetakAbsensi(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'bulan'    => 'required|numeric|between:1,12',
            'tahun'    => 'required|numeric',
        ]);

        // 1. Ambil informasi nama kelas dan nama ustadz (wali kelas)
        $kelas = DB::table('kelas')
            ->leftJoin('ustadz', 'kelas.ustadz_id', '=', 'ustadz.id')
            ->select('kelas.*', 'ustadz.nama_ustadz')
            ->where('kelas.id', $request->kelas_id)
            ->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Data kelas tidak ditemukan.');
        }

        // 2. Ambil daftar santri aktif di kelas ini (sesuai struktur DB Anda)
        $daftarSantri = DB::table('santri')
            ->where('kelas_id', $request->kelas_id)
            ->where('status_santri', 'aktif')
            ->orderBy('nama_santri', 'asc')
            ->get();

        // 3. Hitung jumlah hari dalam bulan tersebut (misal: 28, 29, 30, atau 31 hari)
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $request->bulan, $request->tahun);

        // 4. Konversi angka bulan ke teks nama bulan Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ][$request->bulan];

        $tahun = $request->tahun;

        // 5. Generate PDF menggunakan dompdf dengan layout Landscape kertas A4
        $pdf = Pdf::loadView('admin.kelas.cetak_absensi', compact('kelas', 'daftarSantri', 'jumlahHari', 'namaBulan', 'tahun'))
                  ->setPaper('a4', 'landscape');

        // 6. Streaming langsung ke browser agar bisa di-print/download
        return $pdf->stream('Form_Absensi_' . str_replace(' ', '_', $kelas->nama_kelas) . '_' . $namaBulan . '_' . $tahun . '.pdf');
    }

    // 6. Menghapus Data Kelas
    public function destroy($id)
    {
        $opsiSantri = \DB::table('santri')->where('kelas_id', $id)->exists();
        if ($opsiSantri) {
            return redirect()->route('admin.kelas.index')->with('error', 'Kelas tidak bisa dihapus karena masih memiliki santri aktif di dalamnya!');
        }

        \DB::table('kelas')->where('id', $id)->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil dihapus!');
    }

    // =========================================================================
    // 🎓 FITUR KENAIKAN KELAS MASSAL (OPSI A)
    // =========================================================================

    /**
     * Menampilkan form kenaikan kelas massal
     */
    public function kenaikanKelasForm(Request $request)
    {
        // Ambil semua daftar kelas untuk filter asal & pilihan tujuan
        $daftarKelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        $santri = [];
        $kelasAsalId = $request->kelas_asal_id;

        // Jika admin sudah memilih kelas asal, tarik data santri yang aktif di kelas tersebut
        if ($kelasAsalId) {
            $santri = DB::table('santri')
                ->where('kelas_id', $kelasAsalId)
                ->where('status_santri', 'aktif')
                ->orderBy('nama_santri', 'asc')
                ->get();
        }

        return view('admin.kelas.kenaikan', compact('daftarKelas', 'santri', 'kelasAsalId'));
    }

    /**
     * Memproses kenaikan kelas secara massal menggunakan Query Builder
     */
    public function prosesKenaikanKelas(Request $request)
    {
        $request->validate([
            'kelas_asal_id'  => 'required',
            'kelas_tujuan'   => 'required',
            'santri_ids'     => 'required|array|min:1',
        ], [
            'santri_ids.required' => 'Silakan pilih minimal satu santri yang akan diproses!',
        ]);

        $kelasTujuan = $request->kelas_tujuan;
        $santriIds = $request->santri_ids;

        DB::transaction(function () use ($kelasTujuan, $santriIds) {
            if ($kelasTujuan === 'lulus') {
                // Jika tujuan "Lulus", kosongkan kelas_id dan ubah status_santri menjadi 'lulus'
                DB::table('santri')
                    ->whereIn('id', $santriIds)
                    ->update([
                        'kelas_id'       => null,
                        'status_santri'  => 'lulus',
                        'updated_at'     => now()
                    ]);
            } else {
                // Jika naik ke kelas lain, perbarui kelas_id dan pastikan status tetap aktif
                DB::table('santri')
                    ->whereIn('id', $santriIds)
                    ->update([
                        'kelas_id'       => $kelasTujuan,
                        'status_santri'  => 'aktif',
                        'updated_at'     => now()
                    ]);
            }
        });

        return redirect()->route('admin.kelas.kenaikan', ['kelas_asal_id' => $request->kelas_asal_id])
            ->with('success', 'Proses kenaikan/kelulusan massal santri berhasil diperbarui!');
    }
}