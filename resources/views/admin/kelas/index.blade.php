@extends('layouts.admin')

@section('title', 'Data Master Kelas')
@section('page_title', 'Manajemen Ruang Kelas')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6 text-xs">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <h3 class="text-sm font-bold text-slate-800">Cetak Formulir Absensi Fisik (A4)</h3>
        <p class="text-slate-500 mt-0.5">Pilih parameter kelas dan periode bulan untuk mengunduh form absensi kosongan siap cetak.</p>
    </div>
    
    <form action="{{ route('admin.kelas.cetakAbsensi') }}" method="POST" target="_blank" class="p-5 flex flex-col sm:flex-row items-end gap-3.5">
        @csrf
        <div class="w-full sm:w-1/3">
            <label class="block font-semibold text-slate-600 mb-1.5">Pilih Ruang Kelas</label>
            <select name="kelas_id" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600 text-xs text-slate-700">
                <option value="">-- Pilih Kelas --</option>
                @foreach($daftarKelasAll ?? $daftarKelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full sm:w-1/3">
            <label class="block font-semibold text-slate-600 mb-1.5">Periode Bulan</label>
            <input type="month" name="periode" required value="{{ date('Y-m') }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 text-xs text-slate-700 bg-white">
        </div>

        <div class="w-full sm:w-1/3">
            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-2 px-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                <i class="fa-solid fa-print"></i> Cetak Lembar Absen
            </button>
        </div>
    </form>
</div>

<div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/30">
        <div>
            <h3 class="text-base font-bold text-slate-800">Daftar Ruang Kelas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Pengelompokan ruang belajar dan pemetaan ustadz wali kelas.</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-center">
            <a href="{{ route('admin.kelas.kenaikan') }}" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-150 shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-graduation-cap"></i> Kenaikan Kelas Massal ↗
            </a>
            <button type="button" onclick="openCreateModal()" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-150 shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Tambah Kelas
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="m-6 mb-0 p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs min-w-[500px]">
            <thead>
                <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                    <th class="py-4 px-6 w-1/3">Nama Ruang Kelas</th>
                    <th class="py-4 px-6">Wali Kelas / Pengajar</th>
                    <th class="py-4 px-6 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-100 font-medium">
                @forelse($daftarKelas as $row)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="py-4 px-6 font-bold text-slate-800">
                        <i class="fa-solid fa-door-open text-slate-400 mr-2"></i>{{ $row->nama_kelas }}
                    </td>
                    <td class="py-4 px-6">
                        @if($row->nama_ustadz)
                            <span class="text-slate-700 font-semibold">
                                <i class="fa-solid fa-user-tie text-emerald-600/70 mr-1.5"></i>{{ $row->nama_ustadz }}
                            </span>
                        @else
                            <span class="text-slate-400 italic bg-slate-50 px-2 py-1 rounded text-[11px] border border-slate-100">
                                Belum ada wali kelas
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="openEditModal({{ json_encode($row) }})" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[10px] transition-colors" title="Ubah Nama/Wali">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.kelas.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruang kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-[10px] transition-colors" title="Hapus Kelas">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-12 text-center text-slate-400">
                        <i class="fa-solid fa-school-flag text-3xl text-slate-200 mb-2 block"></i>
                        <span class="text-sm">Belum ada ruang kelas yang terdaftar.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($daftarKelas->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $daftarKelas->links() }}
        </div>
    @endif
</div>

{{-- Memanggil Berkas Modal --}}
@include('admin.kelas.modals.create')
@include('admin.kelas.modals.edit')

<script>
    function openCreateModal() {
        document.getElementById('modal-create-kelas').classList.remove('hidden');
    }

    function openEditModal(data) {
        const form = document.getElementById('form-edit-kelas');
        // Injecting URL Update dinamis sesuai ID data kelas
        form.action = "{{ url('admin/kelas/update') }}/" + data.id;

        // Mengisi value form modal edit sesuai data baris tabel
        document.getElementById('edit-nama-kelas').value = data.nama_kelas;
        document.getElementById('edit-ustadz-id').value = data.ustadz_id ? data.ustadz_id : '';

        document.getElementById('modal-edit-kelas').classList.remove('hidden');
    }

    function closeModal(type) {
        document.getElementById('modal-' + type + '-kelas').classList.add('hidden');
    }
</script>
@endsection