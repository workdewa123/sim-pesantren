@extends('layouts.admin')

@section('title', 'Kelola Rincian Biaya')
@section('page_title', 'Rincian Komponen Biaya Masuk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-xs">
    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 self-start">
        <h3 class="text-sm font-bold text-slate-800 mb-1"><i class="fa-solid fa-circle-plus text-emerald-600 mr-1"></i> Tambah Komponen Biaya</h3>
        <p class="text-slate-400 mb-4">Tambahkan rincian baru seperti uang gedung, seragam, dll.</p>

        <form action="{{ route('admin.rincian.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nama Komponen Biaya</label>
                <input type="text" name="nama_komponen" placeholder="Contoh: Uang Gedung Tambahan" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-emerald-600 focus:outline-none">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Peruntukan Santri</label>
                <select name="jenis_santri" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white focus:border-emerald-600 focus:outline-none">
                    <option value="semua">Semua (Mukim & Non-Mukim)</option>
                    <option value="mukim">Khusus Santri Mukim (Asrama)</option>
                    <option value="non-mukim">Khusus Santri Non-Mukim (Laju)</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nominal Biaya (Rp)</label>
                <input type="number" name="nominal" placeholder="Contoh: 400000" required class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono focus:border-emerald-600 focus:outline-none">
            </div>

            <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors shadow-sm">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Komponen
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800">Daftar Aktif Rincian Biaya</h3>
            <p class="text-slate-400 mt-0.5">Daftar komponen yang otomatis terakumulasi di form pendaftaran wali santri.</p>
        </div>

        @if(session('success'))
            <div class="m-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold border-b border-slate-100 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Nama Komponen</th>
                        <th class="py-3 px-4">Peruntukan</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($semuaRincian as $item)
                    <tr>
                        <td class="py-3 px-4 font-medium text-slate-800">{{ $item->nama_komponen }}</td>
                        <td class="py-3 px-4">
                            @if($item->jenis_santri == 'semua')
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md font-semibold">Semua</span>
                            @elseif($item->jenis_santri == 'mukim')
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md font-semibold">Mukim</span>
                            @else
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 rounded-md font-semibold">Non-Mukim</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-mono font-semibold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 flex items-center justify-center gap-3">
                            <button type="button" 
                                    onclick="openEditModal({{ json_encode($item) }})" 
                                    class="text-amber-500 hover:text-amber-700 p-1 transition-colors">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </button>

                            <form action="{{ route('admin.rincian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komponen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1 transition-colors">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-400 italic">Belum ada komponen biaya tambahan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.pendaftaran.rincian_edit')

<script>
    function openEditModal(item) {
        // 1. Set action form secara dinamis mengarah ke ID rincian tersebut
        const form = document.getElementById('form-edit-rincian');
        form.action = `/admin/rincian-biaya/update/${item.id}`;

        // 2. Isi value input form modal dengan data yang dilempar dari tombol baris tabel
        document.getElementById('edit-nama-komponen').value = item.nama_komponen;
        document.getElementById('edit-jenis-santri').value = item.jenis_santri;
        document.getElementById('edit-nominal').value = item.nominal;

        // 3. Munculkan modal dengan menghapus kelas 'hidden'
        document.getElementById('modal-edit-rincian').classList.remove('hidden');
    }

    function closeEditModal() {
        // Sembunyikan kembali modal dengan menambahkan kelas 'hidden'
        document.getElementById('modal-edit-rincian').classList.add('hidden');
    }
</script>
@endsection