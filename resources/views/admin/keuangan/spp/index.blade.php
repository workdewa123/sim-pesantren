@extends('layouts.keuangan')

@section('title', 'Manajemen Syahriyah')
@section('page_title', 'Pencatatan Khusus Syahriyah / SPP')

@section('content')
<div class="space-y-4 text-xs">
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
        <form action="{{ route('admin.keuangan.spp.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Cari Nama Santri</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama santri..." class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Filter Tahun Hijriyah</label>
                <input type="number" name="tahun" value="{{ request('tahun', date('Y')-622) }}" placeholder="Contoh: 1447" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
            </div>
            <div class="sm:col-span-2 lg:col-span-3 flex flex-wrap gap-2 pt-2 sm:pt-0">
                <button type="submit" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter Data
                </button>
                <button type="button" onclick="openModal('modalCreateSpp')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors">
                    <i class="fa-solid fa-plus mr-1"></i> Pembayaran Baru
                </button>
            </div>
        </form>

        <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <span class="text-slate-500 font-medium"><i class="fa-solid fa-file-excel text-emerald-600 mr-1"></i> Cetak Rekapitulasi Matriks Bulanan:</span>
            <form id="formLaporanSpp" method="POST" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                @csrf
                <input type="hidden" name="jenis_laporan" value="spp_matriks">
                
                <select name="tahun_hijriyah" required class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600 text-xs font-medium">
                    @for($t = 1445; $t <= 1455; $t++)
                        <option value="{{ $t }}" {{ date('Y') == 2026 && $t == 1447 ? 'selected' : '' }}>Tahun {{ $t }} H</option>
                    @endfor
                </select>

                <button type="button" onclick="submitLaporan('preview')" class="px-4 py-1.5 bg-slate-700 hover:bg-slate-800 text-white font-bold rounded-xl transition-colors flex items-center gap-1 text-xs">
                    <i class="fa-solid fa-eye"></i> Lihat Laporan
                </button>

                <button type="button" onclick="submitLaporan('download')" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-colors flex items-center gap-1 text-xs">
                    <i class="fa-solid fa-download"></i> Unduh Rekap (.xls)
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-600 font-bold">
                        <th class="p-3.5 pl-4">Nama Santri</th>
                        <th class="p-3.5 text-center">Periode Tagihan</th>
                        <th class="p-3.5 text-right">Nominal</th>
                        <th class="p-3.5 text-center">Tanggal Masehi</th>
                        <th class="p-3.5 text-center">Status / Bendahara</th>
                        <th class="p-3.5 text-center pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftarSpp as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-3.5 pl-4 font-bold text-slate-700">
                            {{ $row->santri ? $row->santri->nama_santri : 'Santri Terhapus' }}
                        </td>
                        <td class="p-3.5 text-center whitespace-nowrap font-medium text-slate-600">
                            @php
                                $bulanHijriyah = [1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'];
                            @endphp
                            {{ $bulanHijriyah[$row->bulan] ?? $row->bulan }} {{ $row->tahun }} H
                        </td>
                        <td class="p-3.5 text-right font-bold text-slate-700">
                            Rp {{ number_format($row->nominal_bayar, 0, ',', '.') }}
                        </td>
                        <td class="p-3.5 text-center text-slate-600 whitespace-nowrap">
                            {{ $row->tanggal_bayar ? date('d-m-Y', strtotime($row->tanggal_bayar)) : '-' }}
                        </td>
                        <td class="p-3.5 text-center whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider {{ $row->status_pembayaran == 'Lunas' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                {{ $row->status_pembayaran }}
                            </span>
                            @if($row->nama_bendahara)
                                <div class="text-[9px] text-slate-400 mt-0.5"><i class="fa-solid fa-user-check text-[8px]"></i> {{ $row->nama_bendahara }}</div>
                            @endif
                        </td>
                        <td class="p-3.5 text-center whitespace-nowrap pr-4">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="openEditSpp({{ json_encode($row->load('santri')) }})" class="px-2.5 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold rounded-lg transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i> Ubah
                                </button>
                                
                                <form action="{{ route('admin.keuangan.spp.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan iuran ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold rounded-lg transition-colors">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-400 font-medium">Tidak ada riwayat pembayaran Syahriyah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($daftarSpp->hasPages())
            <div class="p-3 bg-slate-50 border-t border-slate-100">{{ $daftarSpp->links() }}</div>
        @endif
    </div>
</div>

@include('admin.keuangan.spp.modals.create')
@include('admin.keuangan.spp.modals.edit')

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

    function openEditSpp(data) {
    const form = document.getElementById('formEditSpp');
    // 1. Perbaiki URL Action Form (Gunakan route Laravel atau URL path yang benar)
    form.action = `{{ url('admin/keuangan/spp/update') }}/${data.id}`;
    
    // 2. Set data yang elemennya mutlak ada di modal edit
    document.getElementById('edit_spp_nama_santri').value = data.santri ? data.santri.nama_santri : "Terhapus";
    document.getElementById('edit_spp_bulan').value = data.bulan;
    document.getElementById('edit_spp_tahun').value = data.tahun;
    document.getElementById('edit_spp_nominal').value = Math.round(data.nominal_bayar);
    
    // 3. Perbaiki ID Tanggal Bayar sesuai yang ada di edit.blade.php
    const inputTanggal = document.getElementById('edit_spp_tanggal_bayar');
    if (inputTanggal) {
        inputTanggal.value = data.tanggal_bayar || "";
    }

    // 4. Cek status pembayaran (Radio Button)
    if (data.status_pembayaran === 'Lunas') {
        document.getElementById('edit_status_lunas').checked = true;
    } else {
        document.getElementById('edit_status_belum').checked = true;
    }

    // 5. Buka Modal
    openModal('modalEditSpp');
    }
    function submitLaporan(aksi) {
        const form = document.getElementById('formLaporanSpp');
        
        if (aksi === 'preview') {
            form.action = "{{ route('admin.keuangan.spp.laporan_matriks.preview') }}";
            form.target = "_blank"; // Supaya terbuka di tab baru tanpa meninggalkan dashboard
        } else {
            form.action = "{{ route('admin.keuangan.spp.laporan_matriks') }}";
            form.target = "_self";  // Langsung mendownload di halaman yang sama
        }
        
        form.submit();
    }
</script>
@endsection