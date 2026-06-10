@extends('layouts.admin')

@section('title', 'Persetujuan Pendaftaran')
@section('page_title', 'Persetujuan Santri Baru')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-base font-bold text-slate-800">Antrean Verifikasi Dokumen</h3>
        <p class="text-xs text-slate-500 mt-0.5">Berikut adalah daftar calon santri yang telah mengisi formulir secara mandiri dan menunggu validasi berkas fisik[cite: 1].</p>
    </div>

    @if(session('success'))
        <div class="m-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center text-sm font-medium">
            <i class="fa-solid fa-circle-check text-emerald-500 mr-2.5 text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-400 font-bold text-xs uppercase tracking-wider border-b border-slate-100">
                    <th class="py-4 px-6">Nama Santri</th>
                    <th class="py-4 px-6">Jenis</th>
                    <th class="py-4 px-6">Wali Santri</th>
                    <th class="py-4 px-6">No. HP</th>
                    <th class="py-4 px-6">Tanggal Daftar</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-100">
                @forelse($antreanSantri as $row)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="py-4 px-6 font-semibold text-slate-800">{{ $row->nama_santri }}</td>
                    <td class="py-4 px-6">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $row->jenis_santri == 'mukim' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ ucfirst($row->jenis_santri) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">{{ $row->nama_ayah }}</td>
                    <td class="py-4 px-6 font-mono text-xs">{{ $row->no_hp_wali }}</td>
                    <td class="py-4 px-6 text-xs text-slate-400">{{ $row->created_at->translatedFormat('d M Y, H:i') }} WIB</td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('admin.persetujuan.detail', $row->id) }}" class="inline-flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-lg text-xs transition-colors duration-150">
                            <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Periksa Berkas
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400">
                        <i class="fa-solid fa-folder-open text-3xl text-slate-200 mb-2 block"></i>
                        <span class="text-sm">Tidak ada antrean pendaftaran baru saat ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection