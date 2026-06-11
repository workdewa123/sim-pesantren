@extends('layouts.media')

@section('title', 'Berita & Kegiatan')
@section('page_title', 'Manajemen Publikasi Berita & Kegiatan')

@section('content')
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-xs">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Arsip Pengumuman & Berita</h3>
            <p class="text-slate-400 mt-0.5">Kelola seluruh konten tulisan kegiatan santri dan siaran resmi pondok pesantren.</p>
        </div>
        <button type="button" onclick="openModal('modalCreate')" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm flex items-center gap-1.5 self-start sm:self-auto cursor-pointer transition-all">
            <i class="fa-solid fa-bullhorn text-sm"></i> Rilis Kegiatan Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto border border-slate-100 rounded-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <th class="p-3" width="6%">No</th>
                    <th class="p-3" width="15%">Foto</th>
                    <th class="p-3">Judul Berita / Kegiatan</th>
                    <th class="p-3" width="14%">Tanggal Rilis</th>
                    <th class="p-3" width="14%">Penulis</th>
                    <th class="p-3 text-center" width="16%">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-50">
                @forelse($kegiatan as $index => $row)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-3 font-medium">{{ $kegiatan->firstItem() + $index }}</td>
                    <td class="p-3">
                        <div class="w-16 h-10 bg-slate-100 rounded-md overflow-hidden border border-slate-200/60">
                            @if($row->foto_kegiatan)
                                <img src="{{ asset('storage/' . $row->foto_kegiatan) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 text-[10px]">No Image</div>
                            @endif
                        </div>
                    </td>
                    <td class="p-3 font-semibold text-slate-800 max-w-xs truncate">{{ $row->judul_kegiatan }}</td>
                    <td class="p-3 text-slate-500">{{ \Carbon\Carbon::parse($row->tanggal_kegiatan)->translatedFormat('d M Y') }}</td>
                    <td class="p-3 font-medium text-slate-500"><i class="fa-regular fa-user text-[10px] mr-1 text-slate-400"></i>{{ $row->penulis }}</td>
                    <td class="p-3 flex justify-center gap-1.5 mt-1.5">
                        <button type="button" onclick="showKegiatan({{ $row->id }})" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg cursor-pointer" title="Pratinjau"><i class="fa-solid fa-eye"></i></button>
                        <button type="button" onclick="editKegiatan({{ $row->id }})" class="p-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg cursor-pointer" title="Koreksi"><i class="fa-solid fa-pen-to-square"></i></button>
                        <form action="{{ route('media.kegiatan.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi kegiatan pondok ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg cursor-pointer" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-5 text-center text-slate-400 bg-slate-50/20">Belum ada publikasi berita atau kegiatan pondok pesantren saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $kegiatan->links() }}
    </div>
</div>

@include('media.kegiatan.modals.create')
@include('media.kegiatan.modals.edit')
@include('media.kegiatan.modals.detail')

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => { modal.classList.add('opacity-100'); }, 20);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('opacity-100');
        setTimeout(() => { modal.classList.add('hidden'); }, 150);
    }

    // Ajax Handler Detail Preview Jendela
    function showKegiatan(id) {
        fetch(`/dashboard-media/kegiatan/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detail_judul').innerText = data.judul_kegiatan;
                document.getElementById('detail_konten').innerText = data.konten_lengkap;
                document.getElementById('detail_penulis').innerText = data.penulis;
                document.getElementById('detail_tanggal').innerHTML = `<i class="fa-regular fa-calendar mr-1"></i> ` + new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
                document.getElementById('detail_foto').src = data.foto_kegiatan ? `/storage/${data.foto_kegiatan}` : 'https://placehold.co/600x400?text=No+Image';
                openModal('modalDetail');
            });
    }

    // Ajax Handler Form Pengisian Koreksi Edit
    function editKegiatan(id) {
        fetch(`/dashboard-media/kegiatan/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_judul').value = data.judul_kegiatan;
                document.getElementById('edit_tanggal').value = data.tanggal_kegiatan;
                document.getElementById('edit_deskripsi').value = data.deskripsi_singkat;
                document.getElementById('edit_konten').value = data.konten_lengkap;
                document.getElementById('formEditKegiatan').action = `/dashboard-media/kegiatan/${id}/update`;
                openModal('modalEdit');
            });
    }
</script>
@endsection