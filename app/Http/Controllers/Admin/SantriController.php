<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    // 1. Menampilkan Daftar Santri dengan Filter Kelas, Nama, dan Jenis Santri
    public function index(Request $request)
    {
        $daftarKelas = \DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        $query = \DB::table('santri')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->select('santri.*', 'kelas.nama_kelas')
            ->where('santri.status_santri', 'aktif');

        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('santri.kelas_id', $request->kelas_id);
        }

        if ($request->has('jenis_santri') && $request->jenis_santri != '') {
            $query->where('santri.jenis_santri', $request->jenis_santri);
        }

        if ($request->has('q') && $request->q != '') {
            $query->where('santri.nama_santri', 'LIKE', '%' . $request->q . '%');
        }

        $daftarSantri = $query->orderBy('santri.nama_santri', 'asc')->paginate(10);

        return view('admin.santri.index', compact('daftarSantri', 'daftarKelas'));
    }

    // 🌟 PERBAIKAN METHOD SHOW: Tambah Left Join Kelas agar nama_kelas terisi otomatis
    public function show($id)
    {
        $santri = \DB::table('santri')
            ->leftJoin('kelas', 'santri.kelas_id', '=', 'kelas.id')
            ->select('santri.*', 'kelas.nama_kelas')
            ->where('santri.id', $id)
            ->first();

        if (!$santri) {
            return response()->json(['error' => 'Data santri tidak ditemukan'], 404);
        }

        return response()->json($santri); 
    }

    // 3. Mengambil Data Detail Santri untuk Form Edit (AJAX)
    public function edit($id)
    {
        $santri = \DB::table('santri')->where('id', $id)->first();
        return response()->json($santri);
    }

    // 4. Memproses Pembaruan Data & Pas Foto Santri
// 4. Memproses Pembaruan Menyeluruh Data Santri (Termasuk Berkas Dokumen)
    public function update(Request $request, $id)
    {
        // Validasi seluruh input data form dari 3 tab
        $request->validate([
            'nama_santri'       => 'required|string|max:255',
            'kelas_id'          => 'nullable|integer',
            'jenis_santri'      => 'required|in:mukim,non-mukim',
            'tahun_masuk'       => 'nullable|integer',
            'pilihan_biaya'     => 'nullable|string|max:255',
            'tanggal_lahir'     => 'nullable|date',
            'no_hp_wali'        => 'nullable|string|max:20',
            'alamat_santri'     => 'nullable|string',
            'nama_ayah'         => 'nullable|string|max:255',
            'nama_ibu'          => 'nullable|string|max:255',
            'alamat_orang_tua'  => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'file_kk'           => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'file_akte'         => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $santriOld = \DB::table('santri')->where('id', $id)->first();
        if (!$santriOld) {
            return redirect()->route('admin.santri.index')->with('error', 'Data santri tidak ditemukan.');
        }

        // 1. Logika Penggantian Pas Foto
        $namaFoto = $santriOld->foto;
        if ($request->hasFile('foto')) {
            if ($santriOld->foto && \Storage::disk('public')->exists('foto_santri/' . $santriOld->foto)) {
                \Storage::disk('public')->delete('foto_santri/' . $santriOld->foto);
            }
            $file = $request->file('foto');
            $namaFoto = $id . '_foto_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto_santri', $namaFoto, 'public');
        }

        // 2. Logika Penggantian Berkas Kartu Keluarga (KK)
        $namaKK = $santriOld->file_kk;
        if ($request->hasFile('file_kk')) {
            if ($santriOld->file_kk && \Storage::disk('public')->exists('dokumen_santri/' . $santriOld->file_kk)) {
                \Storage::disk('public')->delete('dokumen_santri/' . $santriOld->file_kk);
            }
            $fileKK = $request->file('file_kk');
            $namaKK = $id . '_kk_' . time() . '.' . $fileKK->getClientOriginalExtension();
            // Disimpan ke folder storage/app/public/dokumen_santri agar sesuai struktur path URL Anda
            $fileKK->storeAs('dokumen_santri', $namaKK, 'public');
        }

        // 3. Logika Penggantian Berkas Akte Kelahiran
        $namaAkte = $santriOld->file_akte;
        if ($request->hasFile('file_akte')) {
            if ($santriOld->file_akte && \Storage::disk('public')->exists('dokumen_santri/' . $santriOld->file_akte)) {
                \Storage::disk('public')->delete('dokumen_santri/' . $santriOld->file_akte);
            }
            $fileAkte = $request->file('file_akte');
            $namaAkte = $id . '_akte_' . time() . '.' . $fileAkte->getClientOriginalExtension();
            $fileAkte->storeAs('dokumen_santri', $namaAkte, 'public');
        }

        // Eksekusi Update ke Database menggunakan Query Builder
        \DB::table('santri')->where('id', $id)->update([
            'nama_santri'       => $request->nama_santri,
            'kelas_id'          => $request->kelas_id,
            'jenis_santri'      => $request->jenis_santri,
            'tahun_masuk'       => $request->tahun_masuk,
            'pilihan_biaya'     => $request->pilihan_biaya,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'no_hp_wali'        => $request->no_hp_wali,
            'alamat_santri'     => $request->alamat_santri,
            'nama_ayah'         => $request->nama_ayah,
            'nama_ibu'          => $request->nama_ibu,
            'alamat_orang_tua'  => $request->alamat_orang_tua,
            'foto'              => $namaFoto,
            'file_kk'           => $namaKK,
            'file_akte'         => $namaAkte,
            'updated_at'        => now(),
        ]);

        return redirect()->route('admin.santri.index')->with('success', 'Seluruh data biodata dan berkas dokumen santri berhasil diperbarui!');
    }
    // 5. Menghapus Data Santri
    public function destroy($id)
    {
        \DB::table('santri')->where('id', $id)->delete();
        return redirect()->route('admin.santri.index')->with('success', 'Data santri berhasil dihapus dari sistem.');
    }
}