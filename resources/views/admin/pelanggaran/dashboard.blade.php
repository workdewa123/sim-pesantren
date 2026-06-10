@extends('layouts.pelanggaran')

@section('title', 'Statistik Pelanggaran')
@section('page_title', 'Dashboard Ringkasan Kedisiplinan')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Total Santri</span>
            <span class="text-xl font-bold text-slate-800">{{ $totalSantri }} Anak</span>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Bulan Ini</span>
            <span class="text-xl font-bold text-slate-800">{{ $totalPelanggaranBulanIni }} Kasus</span>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-house-chimney font-light"></i>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Santri Mukim</span>
            <span class="text-xl font-bold text-slate-800">{{ $totalMukim }} Santri</span>
        </div>
    </div>

    <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-person-walking-luggage"></i>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 tracking-wider uppercase">Non-Mukim (Laju)</span>
            <span class="text-xl font-bold text-slate-800">{{ $totalNonMukim }} Santri</span>
        </div>
    </div>
</div>

<div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-sm">
    <div class="mb-4">
        <h3 class="text-sm font-bold text-slate-800">Grafik Tren Kasus Pelanggaran</h3>
        <p class="text-xs text-slate-400">Menampilkan jumlah fluktuasi catatan pelanggaran dalam 6 bulan terakhir.</p>
    </div>
    <div class="relative w-full h-64 sm:h-80">
        <canvas id="chartPelanggaran"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartPelanggaran').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: {!! json_encode($chartData) !!},
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#047857'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#94a3b8' },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection