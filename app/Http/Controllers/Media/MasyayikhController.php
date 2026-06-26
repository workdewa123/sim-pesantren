<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masyayikh;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MasyayikhController extends Controller
{
    public function index()
    {
        $masyayikh = Masyayikh::orderBy('id', 'asc')->get();
        return view('media.masyayikh.index', compact('masyayikh'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_masyayikh' => 'required|string|max:255',
            'biografi_lengkap' => 'required',
            'foto_masyayikh' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gelar' => 'nullable|string',
            'jabatan_pesantren' => 'nullable|string'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_masyayikh')) {
            $fotoPath = $request->file('foto_masyayikh')->store('assets/masyayikh', 'public');
        }

        Masyayikh::create([
            'nama_masyayikh' => $request->nama_masyayikh,
            'slug' => Str::slug($request->nama_masyayikh) . '-' . time(),
            'biografi_lengkap' => $request->biografi_lengkap,
            'gelar' => $request->gelar,
            'jabatan_pesantren' => $request->jabatan_pesantren,
            'foto_masyayikh' => $fotoPath
        ]);

        return redirect()->back()->with('success', 'Data Masyayikh berhasil dirilis!');
    }

    public function edit($id)
    {
        $tokoh = Masyayikh::findOrFail($id);
        return response()->json($tokoh);
    }

    public function update(Request $request, $id)
    {
        $tokoh = Masyayikh::findOrFail($id);

        $request->validate([
            'nama_masyayikh' => 'required|string|max:255',
            'biografi_lengkap' => 'required',
            'foto_masyayikh' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gelar' => 'nullable|string',
            'jabatan_pesantren' => 'nullable|string'
        ]);

        $tokoh->nama_masyayikh = $request->nama_masyayikh;
        $tokoh->biografi_lengkap = $request->biografi_lengkap;
        $tokoh->gelar = $request->gelar;
        $tokoh->jabatan_pesantren = $request->jabatan_pesantren;

        if ($request->hasFile('foto_masyayikh')) {
            if ($tokoh->foto_masyayikh) {
                Storage::delete('public/' . $tokoh->foto_masyayikh);
            }
            $tokoh->foto_masyayikh = $request->file('foto_masyayikh')->store('assets/masyayikh', 'public');
        }

        $tokoh->save();
        return redirect()->back()->with('success', 'Data Masyayikh berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tokoh = Masyayikh::findOrFail($id);
        if ($tokoh->foto_masyayikh) {
            Storage::delete('public/' . $tokoh->foto_masyayikh);
        }
        $tokoh->delete();

        return redirect()->back()->with('success', 'Data Masyayikh berhasil dihapus!');
    }
}
