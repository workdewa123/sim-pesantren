@extends('layouts.keuangan')

@section('title', 'Buku Kas Umum')
@section('page_title', 'Pencatatan Operasional Buku Kas Umum')

@section('content')
<div class="space-y-4 text-xs">
    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium shadow-sm flex items-center gap-2 animate-in fade-in duration-200">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-3">
        <form action="{{ route('admin.keuangan.kas.index') }}" method="GET" class="flex flex-col sm:flex-row flex-1 gap-3 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..." class="w-full sm:flex-1 px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10">
            <select name="jenis" class="w-full sm:w-auto px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                <option value="">-- Semua Jenis Kas --</option>
                <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl transition-colors">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
        </form>
        <button type="button" onclick="openModal('modalCreateKas')" class="w-full sm:w-auto px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-colors whitespace-nowrap flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-circle-plus"></i> Tambah Transaksi Kas
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="p-3.5 pl-4">Tanggal</th>
                        <th class="p-3.5">Kategori</th>
                        <th class="p-3.5">Metode</th>
                        <th class="p-3.5">Deskripsi / Keterangan</th>
                        <th class="p-3.5 text-right">Nominal Aliran</th>
                        <th class="p-3.5 text-center pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($daftarKas as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-3.5 pl-4 whitespace-nowrap text-slate-500">
                            <i class="fa-regular fa-calendar text-slate-400 mr-1"></i>{{ date('d/m/Y', strtotime($row->tanggal_transaksi)) }}
                        </td>
                        
                        <td class="p-3.5 whitespace-nowrap font-bold text-slate-800">
                            {{ $row->kategori }}
                        </td>

                        <td class="p-3.5 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded-md font-bold uppercase text-[9px] {{ $row->metode_pembayaran == 'rekening' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                <i class="fa-solid {{ $row->metode_pembayaran == 'rekening' ? 'fa-credit-card' : 'fa-money-bill-wave' }} mr-1"></i>{{ $row->metode_pembayaran }}
                            </span>
                        </td>

                        <td class="p-3.5 max-w-[260px]">
                            <p class="truncate text-slate-600" title="{{ $row->keterangan }}">
                                {{ $row->keterangan ?? '-' }}
                            </p>
                        </td>

                        <td class="p-3.5 text-right whitespace-nowrap font-extrabold text-[13px] {{ $row->jenis_transaksi == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $row->jenis_transaksi == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($row->nominal, 0, ',', '.') }}
                        </td>

                        <td class="p-3.5 text-center whitespace-nowrap pr-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="openDetailKas({{ json_encode($row) }})" class="p-1 px-2 border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-lg transition-colors font-bold flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-eye text-slate-400"></i> Detail
                                </button>
                                
                                <button type="button" onclick="openEditKas({{ json_encode($row) }})" class="p-1 px-2 border border-blue-100 text-blue-600 hover:bg-blue-50/50 rounded-lg transition-colors font-bold flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-pen-to-square text-blue-400"></i> Edit
                                </button>
                                
                                <form action="{{ route('admin.keuangan.kas.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data catatan transaksi kas ini secara permanen?')" class="inline m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 px-2 border border-rose-100 text-rose-600 hover:bg-rose-50/50 rounded-lg transition-colors font-bold flex items-center gap-1 shadow-sm">
                                        <i class="fa-solid fa-trash-can text-rose-400"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-400 font-medium">
                            <i class="fa-solid fa-receipt text-3xl text-slate-200 mb-2 block"></i>
                            Belum ada rekaman log transaksi kas umum yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($daftarKas->hasPages())
        <div class="p-4 bg-slate-50 border-t border-slate-100">
            {{ $daftarKas->links() }}
        </div>
        @endif
    </div>
</div>

@include('admin.keuangan.kas.modals.create')
@include('admin.keuangan.kas.modals.edit')
@include('admin.keuangan.kas.modals.detail') {{-- 🌟 TAMBAHAN BARU --}}

<script>
    // Fungsi Manajemen Kontrol Status Modal
    function openModal(id) {
        const targetModal = document.getElementById(id);
        if(targetModal) {
            targetModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Kunci scroll layar belakang
        }
    }
    
    function closeModal(id) {
        const targetModal = document.getElementById(id);
        if(targetModal) {
            targetModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Bebaskan kembali scroll
        }
    }

    // Fungsi Pengisian Data Otomatis di Modal Edit
    function openEditKas(data) {
        const form = document.getElementById('formEditKas');
        form.action = `{{ url('admin/keuangan/kas-umum/update') }}/${data.id}`;
        document.getElementById('edit_tanggal_transaksi').value = data.tanggal_transaksi;
        document.getElementById('edit_kas_kategori_id').value = data.kategori || "";
        document.getElementById('edit_jenis_transaksi_input').value = data.jenis_transaksi;
        document.getElementById('edit_nominal').value = Math.round(data.nominal);
        document.getElementById('edit_keterangan').value = data.keterangan || "";
        
        const radios = document.getElementsByName('edit_metode_pembayaran');
        for (let r of radios) {
            if (r.value === data.metode_pembayaran) {
                r.checked = true;
            }
        }
        openModal('modalEditKas');
    }

    // Fungsi Mapping Data Otomatis di Modal Detail Baru (🌟 TAMBAHAN BARU)
    function openDetailKas(data) {
        const formattedNominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(data.nominal);
        
        // Atur teks isi di dalam modal detail
        document.getElementById('detail_tanggal').innerText = data.tanggal_transaksi.split('-').reverse().join('/');
        document.getElementById('detail_kategori').innerText = data.kategori;
        document.getElementById('detail_metode').innerText = data.metode_pembayaran.toUpperCase();
        document.getElementById('detail_nominal').innerText = formattedNominal;
        document.getElementById('detail_keterangan').innerText = data.keterangan || '-';
        document.getElementById('detail_bendahara').innerText = data.nama_bendahara || '-';

        // Styling Badge Jenis Transaksi Dinamis
        const badgeJenis = document.getElementById('detail_jenis_badge');
        if(data.jenis_transaksi === 'pemasukan') {
            badgeJenis.innerText = 'Pemasukan Kas';
            badgeJenis.className = "px-2.5 py-0.5 rounded-full font-black uppercase text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-200";
            document.getElementById('detail_nominal').className = "text-lg font-black text-emerald-600";
        } else {
            badgeJenis.innerText = 'Pengeluaran Kas';
            badgeJenis.className = "px-2.5 py-0.5 rounded-full font-black uppercase text-[10px] bg-rose-100 text-rose-800 border border-rose-200";
            document.getElementById('detail_nominal').className = "text-lg font-black text-rose-600";
        }

        openModal('modalDetailKas');
    }
</script>
@endsection