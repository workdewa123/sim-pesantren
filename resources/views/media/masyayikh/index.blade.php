@extends('layouts.media')

@section('title', 'Manajemen Masyayikh')
@section('page_title', 'Manajemen Profil Masyayikh / Tokoh')

@section('content')
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-xs">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Daftar Masyayikh & Guru Pondok</h3>
            <p class="text-slate-400 mt-0.5">Kelola data profil, jabatan, dan biografi ulama pesantren.</p>
        </div>
        <button type="button" onclick="openModal('modalCreateMasyayikh')" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-user-plus text-sm"></i> Tambah Tokoh Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-100">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <th class="p-3.5 w-12 text-center">Foto</th>
                    <th class="p-3.5">Nama & Gelar</th>
                    <th class="p-3.5">Jabatan Struktur</th>
                    <th class="p-3.5 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 font-medium text-slate-600">
                @forelse($masyayikh as $row)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="p-3 text-center">
                        <img src="{{ $row->foto_masyayikh ? asset('storage/' . $row->foto_masyayikh) : 'https://placehold.co/150?text=Avatar' }}" class="w-10 h-10 object-cover rounded-full border border-slate-100 mx-auto">
                    </td>
                    <td class="p-3 font-bold text-slate-800">{{ $row->gelar }} {{ $row->nama_masyayikh }}</td>
                    <td class="p-3"><span class="bg-amber-50 text-amber-700 px-2 py-1 rounded-md border border-amber-100/50">{{ $row->jabatan_pesantren ?? '-' }}</span></td>
                    <td class="p-3 text-center flex justify-center gap-1.5">
                        <button onclick="editMasyayikh({{ $row->id }})" class="p-2 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg cursor-pointer"><i class="fa-solid fa-pen text-xs"></i></button>
                        <form action="{{ route('media.masyayikh.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus profil tokoh ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg cursor-pointer"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400">Belum ada data Masyayikh yang dirilis.</td>
                </tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>

<div id="modalCreateMasyayikh" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-xl overflow-hidden shadow-2xl">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-sm text-slate-800">Tambah Profil Tokoh/Masyayikh</h3>
            <button onclick="closeModal('modalCreateMasyayikh')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('media.masyayikh.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Gelar Depan / Belakang</label>
                    <input type="text" name="gelar" placeholder="Contoh: KH. atau Lc., M.Ag" class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-amber-600">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_masyayikh" required class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-amber-600">
                </div>
            </div>
            <div>
                <label class="block font-semibold mb-1">Jabatan di Pesantren</label>
                <input type="text" name="jabatan_pesantren" placeholder="Contoh: Pengasuh Utama, Dewan Syura" class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-amber-600">
            </div>
            <div>
                <label class="block font-semibold mb-1">Biografi Lengkap</label>
                <textarea name="biografi_lengkap" rows="6" required class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-amber-600"></textarea>
            </div>
            <div>
                <label class="block font-semibold mb-1">Foto Profil</label>
                <input type="file" name="foto_masyayikh" class="w-full px-2 py-1.5 border rounded-xl">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modalCreateMasyayikh')" class="px-4 py-2 border rounded-xl hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 cursor-pointer">Simpan Tokoh</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditMasyayikh" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-xl overflow-hidden shadow-2xl">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-sm text-slate-800">Koreksi Data Tokoh</h3>
            <button onclick="closeModal('modalEditMasyayikh')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditMasyayikh" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Gelar</label>
                    <input type="text" name="gelar" id="edit_gelar" class="w-full px-3 py-2 border rounded-xl focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_masyayikh" id="edit_nama" required class="w-full px-3 py-2 border rounded-xl">
                </div>
            </div>
            <div>
                <label class="block font-semibold mb-1">Jabatan</label>
                <input type="text" name="jabatan_pesantren" id="edit_jabatan" class="w-full px-3 py-2 border rounded-xl">
            </div>
            <div>
                <label class="block font-semibold mb-1">Biografi Lengkap</label>
                <textarea name="biografi_lengkap" id="edit_biografi" rows="6" required class="w-full px-3 py-2 border rounded-xl"></textarea>
            </div>
            <div>
                <label class="block font-semibold mb-1">Ganti Foto Profil <span class="text-slate-400 font-normal">(Kosongkan jika tetap)</span></label>
                <input type="file" name="foto_masyayikh" class="w-full px-2 py-1.5 border rounded-xl">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modalEditMasyayikh')" class="px-4 py-2 border rounded-xl hover:bg-slate-50 cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.getElementById(id).classList.add('flex'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.getElementById(id).classList.remove('flex'); }

    function editMasyayikh(id) {
        fetch(`/dashboard-media/masyayikh/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_gelar').value = data.gelar;
                document.getElementById('edit_nama').value = data.nama_masyayikh;
                document.getElementById('edit_jabatan').value = data.jabatan_pesantren;
                document.getElementById('edit_biografi').value = data.biografi_lengkap;
                document.getElementById('formEditMasyayikh').action = `/dashboard-media/masyayikh/update/${id}`;
                openModal('modalEditMasyayikh');
            });
    }
</script>
@endsection