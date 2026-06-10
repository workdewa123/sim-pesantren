@extends('layouts.keuangan')

@section('title', 'Ringkasan Kas')
@section('page_title', 'Ringkasan & Informasi Kas Kantor')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-800 to-emerald-950 text-white p-5 rounded-2xl shadow-sm border border-emerald-700/50 relative overflow-hidden flex flex-col justify-center">
        <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-300">Total Saldo Kas Saat Ini</span>
        <span class="text-2xl font-black block mt-1 tracking-tight">Rp {{ number_format($saldoSisa, 0, ',', '.') }}</span>
        <div class="absolute right-4 bottom-4 text-emerald-700/30 text-4xl\"><i class="fa-solid fa-vault"></i></div>
    </div>
    
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Akumulasi Pemasukan</span>
            <span class="text-xl font-extrabold text-emerald-600 block mt-0.5">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm"><i class="fa-solid fa-arrow-trend-up"></i></div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Akumulasi Pengeluaran</span>
            <span class="text-xl font-extrabold text-rose-600 block mt-0.5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
        </div>
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm"><i class="fa-solid fa-arrow-trend-down"></i></div>
    </div>
</div>

{{-- 📊 GRAFIK KEUANGAN BULANAN (Tambahan Baru yang Responsif) --}}
<div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm mb-6">
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-800">Grafik Arus Kas Bulanan</h3>
            <p class="text-[11px] text-slate-400 font-medium">Perbandingan visual tren transaksi pemasukan dan pengeluaran.</p>
        </div>
        <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-wider">
            <span class="flex items-center gap-1.5 text-emerald-600"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Masuk</span>
            <span class="flex items-center gap-1.5 text-rose-600"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span> Keluar</span>
        </div>
    </div>
    <div class="relative w-full h-64 sm:h-72 md:h-80">
        <canvas id="grafikKeuangan"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="mb-4">
            <h3 class="text-sm font-bold text-slate-800">Histori Transaksi Terakhir</h3>
            <p class="text-[11px] text-slate-400 font-medium">Memuat 5 data transaksi tunai kas umum yang baru saja diinput bendahara.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase text-[9px] tracking-wider bg-slate-50/50">
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Keterangan</th>
                        <th class="p-3 text-right">Nominal Arus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($transaksiTerakhir as $row)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="p-3 text-slate-400 font-semibold">{{ date('d/m/Y', strtotime($row->tanggal_transaksi)) }}</td>
                        <td class="p-3 font-bold text-slate-700">{{ $row->kategori }}</td>
                        <td class="p-3 font-medium max-w-[180px] truncate text-slate-500" title="{{ $row->keterangan }}">{{ $row->keterangan ?? '-' }}</td>
                        <td class="p-3 text-right font-bold {{ $row->jenis_transaksi == 'pemasukan' ? 'text-emerald-600' : 'text-rose-500' }}">
                            {{ $row->jenis_transaksi == 'pemasukan' ? '+' : '-' }}Rp {{ number_format($row->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 italic font-medium">Belum ada rekaman histori transaksi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between min-h-[300px]">
        <div>
            <div class="mb-4">
                <h3 class="text-sm font-bold text-slate-800">Unduh Laporan Formal (PDF/Excel)</h3>
                <p class="text-[11px] text-slate-400 font-medium">Tentukan rentang tanggal berkas pembukuan kas yang ingin dicetak.</p>
            </div>

            <form id="formLaporan" method="GET" target="_blank" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-500 mb-1">Dari Tanggal</label>
                    <input type="date" id="dari_tanggal" name="dari_tanggal" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-medium text-slate-700">
                </div>
                <div>
                    <label class="block font-bold text-slate-500 mb-1">Sampai Tanggal</label>
                    <input type="date" id="sampai_tanggal" name="sampai_tanggal" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 font-medium text-slate-700">
                </div>
            </form>
        </div>

        <div class="pt-4 border-t border-slate-100 grid grid-cols-2 gap-3">
            <button type="button" onclick="unduhLaporan('pdf')" class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
            </button>
            <button type="button" onclick="unduhLaporan('excel')" class="w-full py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-file-excel"></i> Berkas Excel
            </button>
        </div>
    </div>

</div>

{{-- Memuat pustaka Chart.js secara asinkron lewat CDN resmi --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Script Fungsi Cetak Berkas Pembukuan Kantor
    function unduhLaporan(jenis) {
        const form = document.getElementById('formLaporan');
        const tglDari = document.getElementById('dari_tanggal').value;
        const tglSampai = document.getElementById('sampai_tanggal').value;

        if (!tglDari || !tglSampai) {
            alert('Silakan tentukan kedua tanggal laporan terlebih dahulu.');
            return;
        }

        if (jenis === 'pdf') {
            form.action = "{{ route('admin.keuangan.laporan.cetak') }}";
        } else if (jenis === 'excel') {
            form.action = "{{ route('admin.keuangan.laporan.excel') }}";
        }

        form.submit();
    }

// 2. Script Render Grafik Finansial Otomatis & Responsif
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('grafikKeuangan').getContext('2d');
        
        // Memasukkan data riil hasil query DB dari Controller secara aman
        const dataPemasukan   = @json($dataPemasukan);
        const dataPengeluaran = @json($dataPengeluaran);
        const labelBulan      = @json($labelBulan);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelBulan,
                datasets: [
                    {
                        label: 'Pemasukan (Rp)',
                        data: dataPemasukan,
                        borderColor: '#059669', // Emerald 600
                        backgroundColor: 'rgba(5, 150, 105, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#059669',
                        tension: 0.35,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: dataPengeluaran,
                        borderColor: '#e11d48', // Rose 600
                        backgroundColor: 'rgba(225, 29, 72, 0.05)',
                        borderWidth: 3,
                        pointBackgroundColor: '#e11d48',
                        tension: 0.35,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 10 },
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection