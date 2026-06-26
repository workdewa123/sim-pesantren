@extends('layouts.keuangan')

@section('title', 'Iuran Non-SPP')
@section('page_title', 'Manajemen Iuran Kondisional / Non-SPP')

@section('content')
<div class="space-y-4 text-xs">
    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.keuangan.iuran_lain.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori iuran..." class="px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none w-full sm:w-60">
            <button type="submit" class="px-3 py-1.5 bg-slate-800 text-white font-bold rounded-xl">Cari</button>
        </form>
        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <button type="button" onclick="openModal('modalTambahKategori')" class="px-4 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-colors flex items-center gap-1">
                <i class="fa-solid fa-folder-plus"></i> Buat Kategori Iuran
            </button>
            <button type="button" onclick="openModal('modalLoketBayar')" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-colors flex items-center gap-1">
                <i class="fa-solid fa-hand-holding-dollar"></i> Loket Bayar Iuran
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-4 py-3 bg-slate-50/50 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Daftar Program / Kategori Iuran Aktif</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-600 font-semibold">
                        <th class="p-3 text-center width-12">No</th>
                        <th class="p-3">Nama Program Iuran</th>
                        <th class="p-3 text-center">Tahun Target</th>
                        <th class="p-3 text-center">Jumlah Pembayar</th>
                        <th class="p-3 text-center">Aksi Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($iuranLain as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3 text-center text-slate-400 font-medium">{{ $iuranLain->firstItem() + $index }}</td>
                            <td class="p-3 font-bold text-slate-800 uppercase">{{ $item->nama_iuran }}</td>
                            <td class="p-3 text-center font-medium text-slate-600">{{ $item->tahun_hijriyah }} H</td>
                            <td class="p-3 text-center">
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md font-bold">{{ $item->pembayaran_count }} Santri</span>
                            </td>
                            <td class="p-3 flex items-center justify-center gap-1.5">
                                <button type="button" onclick="openEditIuran({{ json_encode($item) }})" class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg font-bold transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.keuangan.iuran_lain.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori iuran ini beserta seluruh riwayat pembayarannya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada program iuran kondisional yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($iuranLain->hasPages())
            <div class="p-3 border-t border-slate-100 bg-slate-50/30">
                {{ $iuranLain->links() }}
            </div>
        @endif
    </div>
</div>

@include('admin.keuangan.iuran_lain.modals.crud_kategori')
@include('admin.keuangan.iuran_lain.modals.loket_pembayaran')

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
    function openEditIuran(data) {
        const form = document.getElementById('formEditKategori');
        form.action = `{{ url('admin/keuangan/iuran-lain/update') }}/${data.id}`;
        document.getElementById('edit_nama_iuran').value = data.nama_iuran;
        document.getElementById('edit_tahun_hijriyah').value = data.tahun_hijriyah;
        openModal('modalEditKategori');
    }
</script>
@endsection