<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    // 1. Menampilkan Daftar Santri dengan Filter Kelas
    // 1. Menampilkan Daftar Santri dengan Filter Kelas, Nama, dan Jenis Santri
    public function index(Request $request)
    {
        // Ambil data semua kelas untuk isi dropdown filter di view
        $daftarKelas = \DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        // Query dasar: Menggunakan nama_santri dan status_santri sesuai database Anda
        $query = \DB::table('santri')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->select('santri.*', 'kelas.nama_kelas')
            ->where('santri.status_santri', 'aktif'); // Menggunakan 'status_santri' dan 'aktif'

        // A. Jika Admin memilih kelas tertentu di dropdown filter
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('santri.kelas_id', $request->kelas_id);
        }

        // B. TAMBAHAN: Filter Berdasarkan Jenis Santri (mukim/non-mukim)
        if ($request->has('jenis_santri') && $request->jenis_santri != '') {
            $query->where('santri.jenis_santri', $request->jenis_santri);
        }

        // C. TAMBAHAN: Pencarian Berdasarkan Nama Santri (Pencarian fleksibel dengan LIKE)
        if ($request->has('cari_nama') && $request->cari_nama != '') {
            $query->where('santri.nama_santri', 'like', '%' . $request->cari_nama . '%');
        }

        $daftarSantri = $query->orderBy('santri.nama_santri', 'asc')->paginate(10);

        return view('admin.santri.index', compact('daftarSantri', 'daftarKelas'));
    }

    // 2. Menampilkan Detail Biodata Santri
    public function show($id)
    {
        $santri = \DB::table('santri')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->select('santri.*', 'kelas.nama_kelas')
            ->where('santri.id', $id)
            ->first();

        if (!$santri) abort(404);

        return view('admin.santri.show', compact('santri'));
    }

    // 3. Menampilkan Form Edit Data / Plotting Kelas Santri
    public function edit($id)
    {
        $santri = \DB::table('santri')->where('id', $id)->first();
        if (!$santri) abort(404);

        $daftarKelas = \DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        return view('admin.santri.edit', compact('santri', 'daftarKelas'));
    }

    // 4. Memperbarui Data Santri (Kelas & Jenis Santri)
   // 4. Memperbarui Data Santri (Kelas, Jenis Santri, & Pas Foto)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_santri'  => 'required|string|max:255',
            'kelas_id'     => 'required',
            'jenis_santri' => 'required|in:mukim,non-mukim',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto maks 2MB
        ]);

        // Ambil data santri lama untuk mengecek foto lama
        $santriOld = \DB::table('santri')->where('id', $id)->first();
        $namaFoto = $santriOld->foto; // default pakai foto lama

        // Jika Admin mengunggah foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage jika sebelumnya sudah ada foto
            if ($santriOld->foto && \Storage::disk('public')->exists('foto_santri/' . $santriOld->foto)) {
                \Storage::disk('public')->delete('foto_santri/' . $santriOld->foto);
            }

            // Buat nama file unik: contoh 14_1712345678.jpg
            $file = $request->file('foto');
            $namaFoto = $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan file ke folder: storage/app/public/foto_santri
            $file->storeAs('foto_santri', $namaFoto, 'public');
        }

        \DB::table('santri')->where('id', $id)->update([
            'nama_santri'  => $request->nama_santri,
            'kelas_id'     => $request->kelas_id,
            'jenis_santri' => $request->jenis_santri,
            'foto'         => $namaFoto, // Simpan nama file foto ke database
            'updated_at'   => now(),
        ]);

        return redirect()->route('admin.santri.index')->with('success', 'Biodata dan pas foto santri berhasil diperbarui!');
    }

    // 5. Menghapus Data Santri
    public function destroy($id)
    {
        \DB::table('santri')->where('id', $id)->delete();
        return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil dihapus dari sistem!');
    }
}