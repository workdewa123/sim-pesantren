@extends('layouts.keuangan')

@section('title', 'Iuran SPP Bulanan')
@section('page_title', 'Manajemen Iuran Wajib SPP Santri')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="bg-white p-5 rounded-2xl border border-emerald-200/60 shadow-sm bg-gradient-to-b from-emerald-50/20 to-white self-start">
        <h3 class="text-xs font-bold text-emerald-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
            <i class="fa-solid fa-wand-magic-sparkles text-emerald-600"></i> Otomatisasi Tagihan
        </h3>
        <p class="text-[11px] text-slate-500 mb-4 leading-relaxed">Gunakan fitur ini untuk merilis lembar tagihan iuran wajib baru secara massal bagi seluruh santri yang berstatus aktif.</p>
        
        <form action="{{ route('admin.keuangan.spp.generate') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Pilih Target Bulan & Tahun</label>
                <div class="grid grid-cols-2 gap-2">
                    <select name="bulan" required class="w-full px-2 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                    <select name="tahun" required class="w-full px-2 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y')-1 }}">{{ date('Y')-1 }}</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nominal Iuran (Rp)</label>
                <input type="number" name="nominal" required value="200000" placeholder="Contoh: 200000" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10">
            </div>
            <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-colors text-center" onclick="return confirm('Rilis tagihan massal untuk bulan terpilih?')">
                <i class="fa-solid fa-bolt mr-1"></i> Generate Tagihan
            </button>
        </form>
    </div>

    <div class="lg:col-span-3 space-y-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm text-xs">
            <form action="{{ route('admin.keuangan.spp.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama santri..." class="px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
                <select name="status" class="px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Semua Status --</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
                <button type="submit" class="bg-emerald-800 hover:bg-emerald-900 text-white font-bold rounded-xl transition-colors py-1.5">
                    <i class="fa-solid fa-filter mr-1"></i> Terapkan Filter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden text-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                        <tr>
                            <th class="p-3">Santri</th>
                            <th class="p-3 text-center">Bulan Tagihan</th>
                            <th class="p-3 text-right">Nominal</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($daftarSpp as $row)
                        <tr class="hover:bg-slate-50/40">
                            <td class="p-3">
                                <p class="font-bold text-slate-800">{{ $row->nama_santri }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Kelas: {{ $row->nama_kelas ?? 'Tanpa Kelas' }}</p>
                            </td>
                            <td class="p-3 text-center text-slate-600 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::create()->month($row->bulan_tagihan)->translatedFormat('F') }} {{ $row->tahun_tagihan }}
                            </td>
                            <td class="p-3 text-right font-bold text-slate-700 whitespace-nowrap">
                                Rp {{ number_format($row->nominal_tagihan, 0, ',', '.') }}
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($row->status_bayar == 'belum')
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase bg-amber-50 text-amber-700 border border-amber-200">Belum Lunas</span>
                                @else
                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span>
                                @endif
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($row->status_bayar == 'belum')
                                <form action="{{ route('admin.keuangan.spp.bayar', $row->id) }}" method="POST" onsubmit="return confirm('Proses pembayaran iuran santri ini?')">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-all text-[11px] shadow-sm">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Tandai Lunas
                                    </button>
                                </form>
                                @else
                                <div class="text-[10px] text-slate-400 leading-tight">
                                    <p class="font-semibold text-emerald-600"><i class="fa-solid fa-calendar-check"></i> Terverifikasi</p>
                                    <p class="text-[9px] mt-0.5">{{ date('d/m/Y', strtotime($row->tanggal_bayar)) }}</p>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 font-medium">Tidak ada lembar tagihan iuran yang sesuai filter.</td>
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
</div>
@endsection