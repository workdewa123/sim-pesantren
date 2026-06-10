@extends('layouts.admin')

@section('title', 'Kenaikan Kelas Santri')
@section('page_title', 'Manajemen Kenaikan Kelas Massal')

@section('content')
<div class="space-y-5 text-xs px-2 sm:px-0">

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold rounded-xl shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base shrink-0"></i>
            <span class="leading-tight">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 font-bold rounded-xl shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-base shrink-0"></i>
            <span class="leading-tight">{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5">
        <h3 class="text-sm font-bold text-slate-800 mb-1">
            <i class="fa-solid fa-filter text-emerald-700 mr-1"></i> Tahap 1: Tentukan Kelas Asal
        </h3>
        <p class="text-slate-500 mb-4 leading-relaxed">Pilih ruang kelas santri saat ini yang ingin dievaluasi kenaikan kelasnya.</p>
        
        <form action="{{ route('admin.kelas.kenaikan') }}" method="GET" class="w-full sm:max-w-xs">
            <div class="relative w-full">
                <select name="kelas_asal_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600 font-medium text-slate-700 shadow-sm appearance-none cursor-pointer">
                    <option value="">-- Pilih Kelas Asal --</option>
                    @foreach($daftarKelas as $k)
                        <option value="{{ $k->id }}" {{ $kelasAsalId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>
            <noscript>
                <button type="submit" class="mt-2 w-full px-4 py-2 bg-slate-800 text-white font-bold rounded-xl">Tampilkan</button>
            </noscript>
        </form>
    </div>

    @if($kelasAsalId)
    <form action="{{ route('admin.kelas.prosesKenaikan') }}" method="POST" class="block">
        @csrf
        <input type="hidden" name="kelas_asal_id" value="{{ $kelasAsalId }}">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="space-y-0.5">
                    <h3 class="text-sm font-bold text-slate-800">
                        <i class="fa-solid fa-graduation-cap text-emerald-700 mr-1"></i> Tahap 2: Atur Kelas Tujuan & Eksekusi
                    </h3>
                    <p class="text-slate-500 leading-relaxed">Centang santri yang dinyatakan **Naik Kelas**, lalu arahkan ke ruang kelas baru mereka.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 w-full lg:w-auto">
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="font-semibold text-slate-600 whitespace-nowrap">Pindahkan Ke:</span>
                    </div>
                    
                    <div class="relative w-full sm:w-48 md:w-56">
                        <select name="kelas_tujuan" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:outline-none focus:border-emerald-600 bg-white text-emerald-800 shadow-sm appearance-none cursor-pointer">
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach($daftarKelas as $kt)
                                @if($kt->id != $kelasAsalId)
                                    <option value="{{ $kt->id }}">⬆️ KE KELAS: {{ $kt->nama_kelas }}</option>
                                @endif
                            @endforeach
                            <option value="lulus" class="text-rose-700 font-bold">🎓 LULUS / JADI ALUMNI</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                    
                    <button type="submit" onclick="return confirm('Apakah Anda yakin data centang dan ruang kelas tujuan sudah benar? Tindakan pemindahan massal ini akan langsung mengubah data aktif santri.')" class="w-full sm:w-auto px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer active:scale-[0.98]">
                        <i class="fa-solid fa-bolt"></i> Proses Massal
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto w-full block scrollbar-thin">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-slate-600 font-bold tracking-wide">
                            <th class="py-3 px-4 w-12 text-center select-none">
                                <input type="checkbox" id="checkAll" checked class="w-4 h-4 rounded accent-emerald-700 cursor-pointer">
                            </th>
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Nama Lengkap Santri</th>
                            <th class="py-3 px-4 w-32">Jenis Santri</th>
                            <th class="py-3 px-4 w-32 text-center">Status Sekarang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        @forelse($santri as $index => $row)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" name="santri_ids[]" value="{{ $row->id }}" checked class="santri-checkbox w-4 h-4 rounded accent-emerald-700 cursor-pointer">
                            </td>
                            <td class="py-3 px-4 text-center text-slate-400 font-normal">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-bold text-slate-800 break-words max-w-[200px] sm:max-w-none">
                                {{ $row->nama_santri }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-2 py-0.5 rounded-md font-semibold text-[10px] {{ $row->jenis_santri === 'Mukim' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">
                                    {{ $row->jenis_santri }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-md font-bold text-[10px] uppercase border border-emerald-100">
                                    {{ $row->status_santri }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 bg-white">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-user-slash text-3xl text-slate-200"></i>
                                    <span class="text-xs font-normal">Tidak ada santri aktif di kelas ini yang dapat dipindahkan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </form>
    @endif
</div>

<script>
    // Fitur check/uncheck semua baris santri secara instan
    document.getElementById('checkAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.santri-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection