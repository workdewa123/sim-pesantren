@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="mb-8 p-6 bg-gradient-to-r from-emerald-800 to-teal-900 rounded-2xl shadow-md text-white">
    <h3 class="text-xl font-bold">Assalamu'alaikum, {{ Auth::user()->name }}!</h3>
    <p class="text-emerald-100 text-sm mt-1">Selamat datang di panel utama pengelolaan administrasi pondok pesantren. Berikut adalah kondisi data operasional terkini.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-6 flex items-center transition-all duration-200 hover:shadow-md">
        <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl font-semibold">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Santri Aktif</p>
            <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalSantri }} <span class="text-sm font-normal text-slate-400">Orang</span></h4>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-6 flex items-center transition-all duration-200 hover:shadow-md">
        <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 text-xl font-semibold">
            <i class="fa-solid fa-bed"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Santri Mukim</p>
            <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMukim }} <span class="text-sm font-normal text-slate-400">Orang</span></h4>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-6 flex items-center transition-all duration-200 hover:shadow-md">
        <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 text-xl font-semibold">
            <i class="fa-solid fa-house-user"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Santri Non-Mukim</p>
            <h4 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalNonMukim }} <span class="text-sm font-normal text-slate-400">Orang</span></h4>
        </div>
    </div>

</div>
@endsection