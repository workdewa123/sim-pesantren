@extends('layouts.keuangan')

@section('title', 'Buku Kas Umum')
@section('page_title', 'Pencatatan Operasional Buku Kas Umum')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4 order-2 lg:order-1">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-xs">
            <form action=\"{{ route('admin.keuangan.kas.index') }}\" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..." class="flex-1 px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10">
                <select name="jenis" class="px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Semua Jenis Kas --</option>
                    <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-emerald-800 hover:bg-emerald-900 text-white font-bold rounded-xl transition-colors">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden text-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                        <tr>
                            <th class="p-3 text-center">Tanggal</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Keterangan</th>
                            <th class="p-3 text-right">Nominal</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($daftarKas as $row)
                        <tr class="hover:bg-slate-50/40">
                            <td class="p-3 text-slate-500 whitespace-nowrap text-center">{{ date('d/m/Y', strtotime($row->tanggal_transaksi)) }}</td>
                            <td class="p-3 font-semibold text-slate-700 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-700">{{ $row->kategori }}</span>
                            </td>
                            <td class="p-3 text-slate-600 min-w-[150px] max-w-xs truncate" title="{{ $row->keterangan }}">{{ $row->keterangan ?? '-' }}</td>
                            <td class="p-3 font-bold text-right whitespace-nowrap {{ $row->jenis_transaksi == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $row->jenis_transaksi == 'pemasukan' ? '+' : '-' }} {{ number_format($row->nominal, 0, ',', '.') }}
                            </td>
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.keuangan.kas.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-xs transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-medium">Tidak ada catatan transaksi kas yang cocok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($daftarKas->hasPages())
            <div class="p-3 bg-slate-50 border-t border-slate-100">{{ $daftarKas->links() }}</div>
            @endif
        </div>
    </div>

    <div class="order-1 lg:order-2 self-start">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-xs">
            <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4 flex items-center gap-1.5">
                <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Catat Transaksi Baru
            </h3>
            
            <form action="{{ route('admin.keuangan.kas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 bg-white">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Jenis Transaksi</label>
                    <div class="flex gap-4 p-2 bg-slate-50 rounded-xl border border-slate-100">
                        <label class="flex items-center gap-1.5 font-medium text-emerald-700 cursor-pointer">
                            <input type="radio" name="jenis_transaksi" value="pemasukan" checked class="text-emerald-600 focus:ring-emerald-500"> Pemasukan (+)
                        </label>
                        <label class="flex items-center gap-1.5 font-medium text-rose-600 cursor-pointer">
                            <input type="radio" name="jenis_transaksi" value="pengeluaran" class="text-rose-600 focus:ring-rose-500"> Pengeluaran (-)
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Kategori Kelompok</label>
                    <input type="text" name="kategori" required placeholder="Contoh: Donasi, Listrik, Konsumsi, dll." class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Nominal (Rupiah)</label>
                    <input type="number" name="nominal" required placeholder="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 font-bold text-slate-800">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="3" placeholder="Detail deskripsi iuran kas..." class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-colors text-center">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Simpan Transaksi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
// Pasang event listener pada dropdown Kategori di form Buku Kas Umum Anda
document.getElementById('kas_kategori_id').addEventListener('change', function() {
    // Ambil data-tipe dari option yang dipilih (pemasukan / pengeluaran)
    const selectedOption = this.options[this.selectedIndex];
    const tipe = selectedOption.getAttribute('data-tipe'); 
    
    if(tipe) {
        // Otomatis pilih/kunci radio button atau dropdown tipe_transaksi Anda
        document.getElementById('jenis_transaksi_input').value = tipe;
    }
});
</script>