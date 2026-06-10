@extends('layouts.admin')

@section('title', 'Detail Verifikasi Santri')
@section('page_title', 'Validasi Berkas Calon Santri')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Detail Informasi Singkat -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 uppercase tracking-wide">Data Profil Formulir</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs text-slate-400 block">Nama Calon Santri</span>
                    <strong class="text-slate-800">{{ $santri->nama_santri }}</strong>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Tanggal Lahir</span>
                    <strong class="text-slate-800">{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</strong>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Orang Tua / Wali (Ayah & Ibu)</span>
                    <strong class="text-slate-800">{{ $santri->nama_ayah }} & {{ $santri->nama_ibu }}</strong>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Kontak WA Wali</span>
                    <strong class="text-slate-800">{{ $santri->no_hp_wali }}</strong>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-xs text-slate-400 block">Alamat Tinggal</span>
                    <p class="text-slate-700 font-medium mt-0.5">{{ $santri->alamat_santri }}</p>
                </div>
            </div>
        </div>

        <!-- Section Peninjauan Dokumen Unggahan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
            <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4 uppercase tracking-wide">Lampiran Dokumen Digital</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <span class="block text-xs font-semibold text-slate-500 mb-2">Scan Kartu Keluarga (KK):</span>
                    <div class="border border-slate-200 rounded-xl p-2 bg-slate-50">
                        <img src="{{ asset('storage/' . $santri->file_kk) }}" class="rounded-lg w-full h-auto max-h-60 object-cover border border-slate-200 shadow-inner" alt="Berkas KK">
                        <a href="{{ asset('storage/' . $santri->file_kk) }}" target="_blank" class="block text-center text-xs font-bold text-emerald-700 hover:underline mt-2"><i class="fa-solid fa-up-right-from-square mr-1"></i> Perbesar Gambar</a>
                    </div>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-slate-500 mb-2">Scan Akte Kelahiran:</span>
                    <div class="border border-slate-200 rounded-xl p-2 bg-slate-50">
                        <img src="{{ asset('storage/' . $santri->file_akte) }}" class="rounded-lg w-full h-auto max-h-60 object-cover border border-slate-200 shadow-inner" alt="Berkas Akte">
                        <a href="{{ asset('storage/' . $santri->file_akte) }}" target="_blank" class="block text-center text-xs font-bold text-emerald-700 hover:underline mt-2"><i class="fa-solid fa-up-right-from-square mr-1"></i> Perbesar Gambar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Panel Eksekusi & Ploting Kelas -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 h-fit sticky top-6">
        <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4 uppercase tracking-wide">Otorisasi Kelulusan</h3>
        
        <form action="{{ route('admin.persetujuan.setuju', $santri->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tempatkan ke Kelas</label>
                <select name="kelas_id" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white text-slate-700">
                    <option value="" disabled selected>-- Pilih Ruang Kelas --</option>
                    @foreach($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->jenjang }})</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-slate-400 mt-1">Calon santri wajib di-ploting ke dalam satu kelas sebelum statusnya diaktifkan di sistem.</p>
            </div>

            <div class="pt-2">
                <button type="submit" onclick="return confirm('Apakah berkas fisik sudah sesuai dan Anda yakin ingin mengaktifkan santri ini?')" 
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-4 rounded-xl text-sm transition-all duration-150 shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-check"></i> Setujui & Aktifkan Santri
                </button>
                <a href="{{ route('admin.persetujuan.index') }}" class="block text-center text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors mt-3">Kembali ke Antrean</a>
            </div>
        </form>
    </div>

</div>
@endsection