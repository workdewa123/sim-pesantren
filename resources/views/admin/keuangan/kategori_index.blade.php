@extends('layouts.keuangan')

@section('title', 'Kategori Keuangan')
@section('page_title', 'Master Pengelola Kategori Transaksi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-xs">
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm self-start">
        <h3 class="font-bold text-slate-700 text-sm mb-3">Tambah Kategori Baru</h3>
        <form action="{{ route('admin.keuangan.kategori.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" required placeholder="Contoh: Listrik, Donasi, dll" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Jenis Sifat Aliran Kas</label>
                <select name="tipe_kategori" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="pemasukan">Pemasukan (Uang Masuk)</option>
                    <option value="pengeluaran">Pengeluaran (Uang Keluar)</option>
                </select>
            </div>
            <button type="submit" class="w-full py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-bold rounded-xl shadow-sm transition-colors">
                Simpan Kategori
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                <tr>
                    <th class="p-3">Nama Kategori</th>
                    <th class="p-3 text-center">Tipe Transaksi</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kategoris as $kategori)
                <tr class="hover:bg-slate-50/40">
                    <td class="p-3 font-bold text-slate-700">{{ $kategori->nama_kategori }}</td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <span class="px-2.5 py-0.5 rounded text-[9px] font-black uppercase {{ $kategori->tipe_kategori == 'pemasukan' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ $kategori->tipe_kategori }}
                        </span>
                    </td>
                    <td class="p-3 text-center whitespace-nowrap">
                        <form action="{{ route('admin.keuangan.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-8 text-center text-slate-400 font-medium">Belum ada master kategori dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection