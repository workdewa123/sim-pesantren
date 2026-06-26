<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\IuranLain;
use App\Models\PembayaranIuranLain;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Keuangan;
use App\Models\Kategori; // Diimpor dengan benar agar tidak class not found

class IuranLainController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $iuranLain = IuranLain::withCount('pembayaran')
            ->when($search, function($query) use ($search) {
                return $query->where('nama_iuran', 'like', "%{$search}%");
            })
            ->orderBy('tahun_hijriyah', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        
        $historiBayar = PembayaranIuranLain::with(['santri', 'iuranLain'])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('admin.keuangan.iuran_lain.index', compact('iuranLain', 'kelas', 'historiBayar'));
    }

    // 1. MEMBUAT PROGRAM IURAN BARU (Tanpa mengotak-atik tabel kategoris)
    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'tahun_hijriyah' => 'required|integer',
        ]);

        try {
            IuranLain::create([
                'nama_iuran' => strtoupper($request->nama_iuran),
                'tahun_hijriyah' => $request->tahun_hijriyah,
            ]);

            return redirect()->back()->with('success', 'Program Iuran baru berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan program iuran: ' . $e->getMessage());
        }
    }

    // 2. MENGEDIT PROGRAM IURAN (Hanya mengubah nama program iuran, tidak membuat duplikat di tabel kategoris)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'tahun_hijriyah' => 'required|integer',
        ]);

        try {
            $iuran = IuranLain::findOrFail($id);
            $iuran->update([
                'nama_iuran' => strtoupper($request->nama_iuran),
                'tahun_hijriyah' => $request->tahun_hijriyah,
            ]);

            return redirect()->back()->with('success', 'Program iuran berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $iuran = IuranLain::findOrFail($id);
            $iuran->delete();
            return redirect()->back()->with('success', 'Program iuran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // 3. PROSES LOKET PEMBAYARAN (Otomatis masuk ke kategori tunggal 'Iuran Santri')
    public function storePembayaran(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'santri_id' => 'required',
            'iuran_lain_id' => 'required',
            'nominal_bayar' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|in:cash,rekening',
        ]);

        // 🌟 PENGAMAN BARU: Cek apakah santri ini sudah pernah membayar iuran ini sebelumnya
        $sudahBayar = PembayaranIuranLain::where('santri_id', $request->santri_id)
                        ->where('iuran_lain_id', $request->iuran_lain_id)
                        ->exists();

        if ($sudahBayar) {
            return redirect()->back()->with('error', 'Gagal! Santri yang Anda pilih sudah pernah membayar dan melunasi program iuran ini sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $santri = Santri::findOrFail($request->santri_id);
            $iuran = IuranLain::findOrFail($request->iuran_lain_id);

            // Cari atau buat otomatis kategori tunggal 'Iuran Santri'
            $kategoriNamaTunggal = 'Iuran Santri';
            $kategori = Kategori::firstOrCreate(
                ['nama_kategori' => $kategoriNamaTunggal],
                ['tipe_kategori' => 'pemasukan']
            );

            // Simpan Histori Transaksi Pembayaran Santri
            PembayaranIuranLain::create([
                'santri_id' => $request->santri_id,
                'iuran_lain_id' => $request->iuran_lain_id,
                'nominal_bayar' => $request->nominal_bayar,
                'tanggal_bayar' => $request->tanggal_bayar,
                'nama_bendahara' => Auth::user()->name ?? 'Bendahara'
            ]);

            // Masukkan data ke Buku Kas Besar (keuangans)
            Keuangan::create([
                'tanggal_transaksi' => $request->tanggal_bayar,
                'jenis_transaksi' => 'pemasukan',
                'kategori_id' => $kategori->id, 
                'kategori' => $kategoriNamaTunggal, 
                'nominal' => $request->nominal_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'keterangan' => "PEMBAYARAN " . $iuran->nama_iuran . " A.N " . strtoupper($santri->nama_santri),
                'nama_bendahara' => Auth::user()->name ?? 'Bendahara'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil disimpan dan dibukukan ke Kas Besar!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
        }
    }
}