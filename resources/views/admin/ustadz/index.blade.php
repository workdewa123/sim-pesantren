@extends('layouts.admin')

@section('title', 'Data Master Ustadz')
@section('page_title', 'Manajemen Data Ustadz')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/30">
        <div>
            <h3 class="text-base font-bold text-slate-800">Daftar Dewan Asatidzah</h3>
            <p class="text-xs text-slate-500 mt-0.5">Pengelolaan data guru pengajar resmi pondok pesantren.</p>
        </div>
        <button type="button" onclick="openCreateModal()" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all duration-150 shadow-md shadow-emerald-700/10 flex items-center gap-2 self-start sm:self-center">
            <i class="fa-solid fa-plus"></i> Tambah Ustadz
        </button>
    </div>

    @if(session('success'))
        <div class="m-6 mb-0 p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs min-w-[700px]">
            <thead>
                <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                    <th class="py-4 px-6 w-1/4">Nama Pengajar</th>
                    <th class="py-4 px-6">Spesialisasi Kitab</th>
                    <th class="py-4 px-6">No. WhatsApp</th>
                    <th class="py-4 px-6">Asal Alamat</th>
                    <th class="py-4 px-6 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-100 font-medium">
                @forelse($daftarUstadz as $row)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="py-4 px-6 font-bold text-slate-800">{{ $row->nama_ustadz }}</td>
                    <td class="py-4 px-6">
                        <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-md text-[10px] font-bold border border-emerald-100 uppercase tracking-tighter">
                            {{ $row->spesialisasi }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-slate-500">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $row->no_hp) }}" target="_blank" class="hover:text-emerald-700 transition-colors">
                            {{ $row->no_hp }}
                        </a>
                    </td>
                    <td class="py-4 px-6 text-slate-400 max-w-xs truncate">{{ $row->alamat }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="openEditModal({{ json_encode($row) }})" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-[10px] transition-colors" title="Ubah Data">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.ustadz.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ustadz ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-[10px] transition-colors" title="Hapus Data">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400 italic">
                        <i class="fa-solid fa-user-tie text-3xl text-slate-200 mb-2 block"></i>
                        Belum ada data ustadz yang didaftarkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($daftarUstadz->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $daftarUstadz->links() }}
        </div>
    @endif
</div>

{{-- Memanggil File Modal --}}
@include('admin.ustadz.modals.create')
@include('admin.ustadz.modals.edit')

<script>
    function openCreateModal() {
        document.getElementById('modal-create-ustadz').classList.remove('hidden');
    }

    function openShowModal(data) {
        document.getElementById('show-nama-header').innerText = data.nama_ustadz;
        document.getElementById('show-spesialisasi-header').innerText = data.spesialisasi;
        document.getElementById('show-spesialisasi').innerText = data.spesialisasi;
        document.getElementById('show-hp').innerText = data.no_hp;
        document.getElementById('show-alamat').innerText = data.alamat;

        document.getElementById('btn-edit-from-show').onclick = function() {
            closeModal('show');
            openEditModal(data);
        };

        document.getElementById('modal-show-ustadz').classList.remove('hidden');
    }

    function openEditModal(data) {
        const form = document.getElementById('form-edit-ustadz');
        // Sesuaikan URL rute di sini sesuai web.php Anda (update/{id})
        form.action = "{{ url('admin/ustadz/update') }}/" + data.id;

        document.getElementById('edit-nama').value = data.nama_ustadz;
        document.getElementById('edit-spesialisasi').value = data.spesialisasi;
        document.getElementById('edit-no-hp').value = data.no_hp;
        document.getElementById('edit-alamat').value = data.alamat;

        // Reset dan tambah method PUT karena form menggunakan POST
        document.getElementById('method-container').innerHTML = '@method("POST")'; 
        // Catatan: Jika route di web.php Anda menggunakan POST untuk update, biarkan POST.

        document.getElementById('modal-edit-ustadz').classList.remove('hidden');
    }

    function closeModal(type) {
        document.getElementById('modal-' + type + '-ustadz').classList.add('hidden');
    }
</script>
@endsection