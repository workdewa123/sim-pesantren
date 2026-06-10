<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UstadzController extends Controller
{
    // 1. Menampilkan Semua Data Ustadz
    public function index()
    {
        $daftarUstadz = \DB::table('ustadz')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ustadz.index', compact('daftarUstadz'));
    }

    // 2. Menampilkan Form Tambah Ustadz
    public function create()
    {
        return view('admin.ustadz.create');
    }

    // 3. Menyimpan Data Ustadz Baru (Tanpa NIY)
    public function store(Request $request)
    {
        $request->validate([
            'nama_ustadz'  => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'required|string',
        ]);

        \DB::table('ustadz')->insert([
            'nama_ustadz'  => $request->nama_ustadz,
            'spesialisasi' => $request->spesialisasi,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('admin.ustadz.index')->with('success', 'Data Ustadz baru berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Ustadz
    public function edit($id)
    {
        $ustadz = \DB::table('ustadz')->where('id', $id)->first();
        if (!$ustadz) abort(404);

        return view('admin.ustadz.edit', compact('ustadz'));
    }

    // 5. Memperbarui Data Ustadz (Tanpa NIY)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ustadz'  => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'required|string',
        ]);

        \DB::table('ustadz')->where('id', $id)->update([
            'nama_ustadz'  => $request->nama_ustadz,
            'spesialisasi' => $request->spesialisasi,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'updated_at'   => now(),
        ]);

        return redirect()->route('admin.ustadz.index')->with('success', 'Data Ustadz berhasil diperbarui!');
    }

    // 6. Menghapus Data Ustadz
    public function destroy($id)
    {
        \DB::table('ustadz')->where('id', $id)->delete();
        return redirect()->route('admin.ustadz.index')->with('success', 'Data Ustadz berhasil dihapus dari sistem!');
    }
}