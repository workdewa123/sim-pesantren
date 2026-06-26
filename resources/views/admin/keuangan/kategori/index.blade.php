@extends('layouts.keuangan')

@section('title', 'Kategori Keuangan')
@section('page_title', 'Master Kategori Transaksi')

@section('content')
<div class="space-y-4 text-xs">
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <span class="font-bold text-slate-700 text-sm">Daftar Kategori Transaksi</span>
        <button type="button" onclick="openModal('modalCreateKategori')" class="bg-emerald-800 hover:bg-emerald-900 text-white font-bold rounded-xl px-4 py-2 shadow-sm transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="w-full overflow-x-auto min-w-full inline-block align-middle">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                    <tr>
                        <th class="p-3 pl-4 w-16">No</th>
                        <th class="p-3">Nama Master Kategori</th>
                        <th class="p-3 w-40">Sifat Aliran Kas</th>
                        <th class="p-3 text-center w-36">Aksi Pilihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @php $no = 1; @endphp
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-3 pl-4 text-slate-400 font-normal">{{ $no++ }}</td>
                        <td class="p-3 font-semibold text-slate-800 uppercase">{{ $kategori->nama_kategori }}</td>
                        <td class="p-3">
                            @if($kategori->tipe_kategori == 'pemasukan')
                                <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold rounded-lg inline-flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-down text-[10px]"></i> Pemasukan
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-50 border border-rose-200 text-rose-700 font-bold rounded-lg inline-flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up text-[10px]"></i> Pengeluaran
                                </span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" onclick="openEditKategori({{ json_encode($kategori) }})" class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1 transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form action="{{ route('admin.keuangan.kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1 transition-colors">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium whitespace-normal">Belum ada master kategori dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Me-load file modal terpisah --}}
@include('admin.keuangan.kategori.modals.create')
@include('admin.keuangan.kategori.modals.edit')

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    function openEditKategori(data) {
        const form = document.getElementById('formEditKategori');
        // Update action URL secara dinamis sesuai id kategori
        form.action = `{{ url('admin/keuangan/kategori/update') }}/${data.id}`; 
        document.getElementById('edit_nama_kategori').value = data.nama_kategori;
        document.getElementById('edit_tipe_kategori').value = data.tipe_kategori;
        openModal('modalEditKategori');
    }
</script>
@endsection