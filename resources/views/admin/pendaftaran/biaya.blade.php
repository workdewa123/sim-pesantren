@extends('layouts.admin')

@section('title', 'Pengaturan Biaya')
@section('page_title', 'Konfigurasi Biaya Bulanan')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="border-b border-slate-100 pb-4 mb-6">
        <h3 class="text-base font-bold text-slate-800">Manajemen Nominal Kesanggupan Biaya</h3>
        <p class="text-xs text-slate-500 mt-0.5">Ubah batas nominal iuran yang akan tampil pada pilihan form pendaftaran mandiri wali santri.</p>
    </div>

    @if(session('success'))
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-semibold flex items-center">
            <i class="fa-solid fa-circle-check mr-2 text-emerald-500 text-sm"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.biaya.update') }}" method="POST" class="space-y-6 text-xs">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3 p-4 bg-slate-50/50 rounded-xl border border-slate-100">
                <span class="block font-bold text-slate-700 text-sm border-b pb-2"><i class="fa-solid fa-hotel text-blue-600 mr-1"></i> Opsi Tarif Santri Mukim</span>
                @foreach($biayaMukim as $bm)
                    <div>
                        <label class="block font-medium text-slate-600 mb-1">Opsi {{ $bm->opsi_ke }} (ID: {{ $bm->id }})</label>
                        <input type="number" name="biaya[{{ $bm->id }}]" value="{{ $bm->nominal }}" required class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono text-slate-800 focus:outline-none focus:border-emerald-600">
                    </div>
                @endforeach
            </div>

            <div class="space-y-3 p-4 bg-slate-50/50 rounded-xl border border-slate-100">
                <span class="block font-bold text-slate-700 text-sm border-b pb-2"><i class="fa-solid fa-bicycle text-amber-600 mr-1"></i> Opsi Tarif Santri Non-Mukim</span>
                @foreach($biayaNonMukim as $bnm)
                    <div>
                        <label class="block font-medium text-slate-600 mb-1">Opsi {{ $bnm->opsi_ke }} (ID: {{ $bnm->id }})</label>
                        <input type="number" name="biaya[{{ $bnm->id }}]" value="{{ $bnm->nominal }}" required class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono text-slate-800 focus:outline-none focus:border-emerald-600">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-md transition-all">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Tarif Baru
            </button>
        </div>
    </form>
</div>
@endsection