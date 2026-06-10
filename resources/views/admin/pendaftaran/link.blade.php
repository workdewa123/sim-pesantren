@extends('layouts.admin')

@section('title', 'Kelola Tautan Pendaftaran')
@section('page_title', 'Tautan Pendaftaran Privat')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-8">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Pengaturan Akses Formulir Digital</h3>
        <p class="text-sm text-slate-500 mt-1">Sesuai kebijakan keamanan, formulir pendaftaran tidak dipublikasikan secara bebas. Gunakan tautan privat di bawah ini untuk dibagikan kepada calon wali santri melalui WhatsApp atau media sosial lainnya[cite: 1].</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center text-sm font-medium">
            <i class="fa-solid fa-circle-check text-emerald-500 mr-2.5 text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Kotak Tautan Utama -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Salin Tautan Privat</label>
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" id="urlInput" value="{{ $registrationUrl }}" readonly
                   class="flex-1 bg-white border border-slate-200 text-slate-700 text-sm px-4 py-3 rounded-lg focus:outline-none font-mono tracking-tight select-all">
            
            <button onclick="copyToClipboard()" 
                    class="bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-5 py-3 rounded-lg text-sm transition-all duration-150 flex items-center justify-center shadow-sm">
                <i class="fa-regular fa-copy mr-2"></i> Salin Link
            </button>
        </div>
    </div>

    <!-- Sesi Keamanan Tingkat Lanjut -->
    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-sm font-bold text-slate-800">Perbarui Token Keamanan</h4>
            <p class="text-xs text-slate-500 mt-0.5">Jika tautan pendaftaran sudah kadaluwarsa atau disalahgunakan, klik tombol di sebelah kanan untuk memperbarui tautan secara instan.</p>
        </div>
        <form action="{{ route('admin.pendaftaran.refresh') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memperbarui tautan? Tautan lama otomatis tidak akan bisa diakses lagi.')">
            @csrf
            <button type="submit" class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-4 py-2.5 rounded-lg text-xs transition-all duration-150 flex items-center shadow-sm">
                <i class="fa-solid fa-rotate mr-2 text-slate-400"></i> Regenerasi Tautan
            </button>
        </form>
    </div>
</div>

<!-- JavaScript Sederhana untuk Fitur Salin teks -->
<script>
function copyToClipboard() {
    var copyText = document.getElementById("urlInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // Untuk perangkat seluler
    navigator.clipboard.writeText(copyText.value);
    
    alert("Tautan pendaftaran berhasil disalin ke papan klip!");
}
</script>
@endsection