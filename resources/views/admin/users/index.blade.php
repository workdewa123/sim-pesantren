@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page_title', 'Manajemen Akun Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm text-xs">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Daftar Pengguna Sistem</h3>
            <p class="text-slate-400 mt-0.5">Kelola data login administrasi dan hak akses kru pengurus pesantren.</p>
        </div>
        <button type="button" onclick="openModal('modalCreate')" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
            <i class="fa-solid fa-user-plus text-sm"></i> Tambah User
        </button>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 font-medium rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto border border-slate-100 rounded-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <th class="p-3" width="8%">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role Hak Akses</th> 
                    <th class="p-3 text-center" width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-50">
                @forelse($users as $index => $user)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="p-3 font-medium">{{ $users->firstItem() + $index }}</td>
                    <td class="p-3 font-semibold text-slate-800">{{ $user->name }}</td>
                    <td class="p-3 text-slate-500">{{ $user->email }}</td>
                    <td class="p-3"> <span class="px-2 py-1 rounded-md font-bold uppercase text-[10px] 
                            @if($user->role == 'admin') bg-rose-50 text-rose-700 border border-rose-100
                            @elseif($user->role == 'bendahara') bg-amber-50 text-amber-700 border border-amber-100
                            @elseif($user->role == 'staf_media') bg-blue-50 text-blue-700 border border-blue-100
                            @else bg-slate-100 text-slate-700 border border-slate-200
                            @endif">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </td>
                    <td class="p-3 flex justify-center gap-1.5">
                        <button type="button" onclick="showUser({{ $user->id }})" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg cursor-pointer" title="Detail"><i class="fa-solid fa-eye"></i></button>
                        <button type="button" onclick="editUser({{ $user->id }})" class="p-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg cursor-pointer" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg cursor-pointer" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-5 text-center text-slate-400 bg-slate-50/30">Belum ada data pengguna sistem terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

@include('admin.users.modals.create')
@include('admin.users.modals.edit')
@include('admin.users.modals.detail')

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Fungsi Mengambil Data Detail via AJAX
    function showUser(id) {
        fetch(`/admin/users/${id}/detail`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detail_id').innerText = data.id;
                document.getElementById('detail_name').innerText = data.name;
                document.getElementById('detail_email').innerText = data.email;
                document.getElementById('detail_role').innerText = data.role.replace('_', ' ').toUpperCase(); // Tambah Pengisian Role Detail
                document.getElementById('detail_created').innerText = new Date(data.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'});
                openModal('modalDetail');
            });
    }

    // Fungsi Mengambil Data Edit & Set Action Form via AJAX
    function editUser(id) {
        fetch(`/admin/users/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_role').value = data.role; // Tambah Set Dropdown Value di Modal Edit
                document.getElementById('formEditUser').action = `/admin/users/${id}/update`;
                openModal('modalEdit');
            });
    }
</script>
@endsection