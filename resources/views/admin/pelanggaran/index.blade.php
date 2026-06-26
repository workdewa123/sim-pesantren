@extends('layouts.pelanggaran')

@section('title', 'Daftar Pelanggaran')
@section('page_title', 'Data Riwayat Pelanggaran Santri')

@section('content')
<div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <p class="text-xs text-slate-500 font-medium">Gunakan filter untuk memantau rekam jejak kedisiplinan harian santri.</p>
    </div>
    
    @if(Auth::user()->role === 'pencatat')
        <button type="button" onclick="bukaModal('create')" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-700/10 transition-all flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i> Catat Pelanggaran
        </button>
    @endif
</div>

<div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm mb-6 text-xs">
    <form action="{{ route('admin.pelanggaran.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <label class="block font-bold text-slate-400 uppercase mb-1.5 tracking-wider text-[10px]">Pencarian Nama</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama santri..." class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 bg-slate-50/30">
        </div>
        
        <div>
            <label class="block font-bold text-slate-400 uppercase mb-1.5 tracking-wider text-[10px]">Filter Kelas</label>
            <select name="kelas_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 bg-white text-slate-700 cursor-pointer">
                <option value="">-- Semua Kelas --</option>
                @foreach($daftarKelas as $kls)
                    <option value="{{ $kls->id }}" {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-bold text-slate-400 uppercase mb-1.5 tracking-wider text-[10px]">Status Tinggal</label>
            <select name="jenis_santri" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 bg-white text-slate-700 cursor-pointer">
                <option value="">-- Semua Jenis --</option>
                <option value="mukim" {{ request('jenis_santri') == 'mukim' ? 'selected' : '' }}>Mukim</option>
                <option value="non-mukim" {{ request('jenis_santri') == 'non-mukim' ? 'selected' : '' }}>Non-Mukim</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-colors flex-1 shadow-sm h-[38px]">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Cari
            </button>
            <a href="{{ route('admin.pelanggaran.index') }}" class="px-3 py-2 border border-slate-200 text-slate-500 hover:bg-slate-50 rounded-xl text-center transition-colors flex items-center justify-center h-[38px]" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
</div>

@if(session('success'))
<div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-2xl font-bold flex items-center gap-3">
    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i> {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                    <th class="py-4 px-5 text-center w-12">No</th>
                    <th class="py-4 px-4 w-32">Tanggal Kejadian</th>
                    <th class="py-4 px-4">Informasi Santri</th>
                    <th class="py-4 px-4 text-center">Tingkat</th>
                    <th class="py-4 px-4">Detail Deskripsi</th>
                    <th class="py-4 px-5 text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 divide-y divide-slate-100">
                @forelse($daftarPelanggaran as $index => $row)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-3 px-5 text-center text-slate-300 font-bold italic">{{ $index + $daftarPelanggaran->firstItem() }}</td>
                    <td class="py-3 px-4 font-semibold text-slate-500">{{ date('d-m-Y', strtotime($row->tanggal_pelanggaran)) }}</td>
                    <td class="py-3 px-4">
                        <span class="font-bold text-slate-800 block leading-tight">{{ $row->nama_santri }}</span>
                        <span class="text-[10px] font-bold text-emerald-600 mt-1 flex items-center gap-1">
                            {{ $row->nama_kelas ?? 'Tanpa Kelas' }} <span class="text-slate-300">•</span> {{ $row->jenis_santri }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase border
                            {{ $row->kategori_pelanggaran == 'Ringan' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}
                            {{ $row->kategori_pelanggaran == 'Sedang' ? 'bg-orange-50 text-orange-700 border-orange-100' : '' }}
                            {{ $row->kategori_pelanggaran == 'Berat' ? 'bg-rose-50 text-rose-700 border-rose-100' : '' }}">
                            {{ $row->kategori_pelanggaran }}
                        </span>
                    </td>
                    <td class="py-3 px-4 max-w-xs truncate text-slate-500 font-medium" title="{{ $row->deskripsi_pelanggaran }}">{{ $row->deskripsi_pelanggaran }}</td>
                    <td class="py-3 px-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="bukaModalDetail({{ $row->santri_id }})" class="p-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs transition-colors" title="Lihat Histori">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </button>

                            @if(Auth::user()->role === 'pencatat')
                                <form action="{{ route('admin.pelanggaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-50 text-rose-400 hover:text-rose-600 rounded-lg text-xs transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 font-medium italic">
                        <i class="fa-solid fa-shield-heart text-3xl text-slate-200 block mb-2"></i>
                        Tidak ditemukan rekam data pelanggaran yang cocok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($daftarPelanggaran->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $daftarPelanggaran->links() }}
        </div>
    @endif
</div>


{{-- Memanggil File Modals --}}
@include('admin.pelanggaran.modals.create')
@include('admin.pelanggaran.modals.detail')

<script>
    function bukaModal(type) {
        if(type === 'create') document.getElementById('modal-create-pelanggaran').classList.remove('hidden');
    }

    function tutupModal(type) {
        if(type === 'create') document.getElementById('modal-create-pelanggaran').classList.add('hidden');
    }

    function bukaModalDetail(santriId) {
        const modal = document.getElementById('modalDetailSantri');
        document.getElementById('modal-nama').innerText = 'Memuat...';
        document.getElementById('modal-tabel-riwayat').innerHTML = '<tr><td colspan="4" class="p-4 text-center">Sinkronisasi data histori...</td></tr>';
        modal.classList.remove('hidden');

        fetch(`/admin/pelanggaran/detail-santri/${santriId}`)
            .then(response => {
                if (!response.ok) throw new Error('Rute tidak ditemukan');
                return response.json();
            })
            .then(data => {
                const snt = data.santri;
                const riwayat = data.riwayat;

                document.getElementById('modal-nama').innerText = snt.nama_santri;
                document.getElementById('modal-kelas').innerText = snt.nama_kelas ?? 'Belum Diplot';
                document.getElementById('modal-status').innerText = snt.jenis_santri;

                const fotoDiv = document.getElementById('modal-foto-container');
                if (snt.foto) {
                    fotoDiv.innerHTML = `<img src="/storage/foto_santri/${snt.foto}" class="w-12 h-14 object-cover rounded-lg border shadow-sm">`;
                } else {
                    fotoDiv.innerHTML = `<div class="w-12 h-14 bg-emerald-700 text-white font-bold rounded-lg flex items-center justify-center text-lg uppercase">${snt.nama_santri.substring(0,1)}</div>`;
                }

                let htmlRows = '';
                if (riwayat.length === 0) {
                    htmlRows = '<tr><td colspan="4" class="p-6 text-center text-slate-400 italic">Alhamdulillah, Santri ini belum memiliki riwayat pelanggaran.</td></tr>';
                } else {
                    riwayat.forEach(row => {
                        let badgeColor = '';
                        if (row.kategori_pelanggaran === 'Ringan') badgeColor = 'bg-amber-50 text-amber-700 border border-amber-100';
                        else if (row.kategori_pelanggaran === 'Sedang') badgeColor = 'bg-orange-50 text-orange-700 border border-orange-100';
                        else badgeColor = 'bg-rose-50 text-rose-700 border border-rose-100';

                        const tgl = new Date(row.tanggal_pelanggaran);
                        const tglFormat = String(tgl.getDate()).padStart(2, '0') + '-' + String(tgl.getMonth() + 1).padStart(2, '0') + '-' + tgl.getFullYear();

                        htmlRows += `
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 text-center text-slate-500 font-semibold">${tglFormat}</td>
                                <td class="p-3 text-center">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase ${badgeColor}">${row.kategori_pelanggaran}</span>
                                </td>
                                <td class="p-3 font-medium text-slate-700 leading-relaxed">${row.deskripsi_pelanggaran}</td>
                                <td class="p-3 text-slate-400 font-bold text-[10px] uppercase">${row.nama_petugas}</td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('modal-tabel-riwayat').innerHTML = htmlRows;
            })
            .catch(error => {
                document.getElementById('modal-tabel-riwayat').innerHTML = '<tr><td colspan="4" class="p-4 text-center text-rose-600 font-bold">Gagal sinkronisasi data histori.</td></tr>';
            });
    }

    function tutupModalDetail() {
        document.getElementById('modalDetailSantri').classList.add('hidden');
    }
</script>
@endsection