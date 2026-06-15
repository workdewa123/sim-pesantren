<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul_kegiatan }} - {{ $profil->nama_pesantren ?? 'Pesantren' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased pt-28 selection:bg-emerald-800 selection:text-white">

    <nav class="fixed top-0 inset-x-0 bg-white/90 backdrop-blur-md z-50 border-b border-slate-200/60 transition-all duration-300">
        <div class="max-w-4xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('landing.index') }}" class="text-xs font-bold text-slate-600 hover:text-emerald-800 transition-colors flex items-center gap-2 group p-2 rounded-lg hover:bg-emerald-50/50">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda
            </a>
            <span class="font-extrabold text-[10px] uppercase tracking-widest text-slate-500 bg-slate-100 border border-slate-200/50 px-3.5 py-1.5 rounded-full select-none">
                {{ $profil->nama_perusahaan ?? 'Perusahaan' }}
            </span>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-5 sm:px-6 pb-24 space-y-8">
        
        <div class="space-y-4 text-center sm:text-left">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3.5 text-[11px] text-slate-400 font-bold uppercase tracking-wider">
                <span class="flex items-center gap-2 bg-emerald-50 text-emerald-800 px-3 py-1 rounded-md border border-emerald-100/60">
                    <i class="fa-regular fa-calendar-check text-xs"></i> 
                    Dipublikasi: {{ \Carbon\Carbon::parse($artikel->tanggal_kegiatan)->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-2 bg-slate-100 text-slate-600 px-3 py-1 rounded-md border border-slate-200/60">
                    <i class="fa-solid fa-user-pen text-xs"></i> 
                    Penulis: {{ $artikel->penulis }}
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-[1.25] text-left">
                {{ $artikel->judul_kegiatan }}
            </h1>
            <div class="w-16 h-1 bg-emerald-800 rounded-full mt-2 sm:mx-0 mx-auto"></div>
        </div>

        @if($artikel->foto_kegiatan)
            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-white p-3 shadow-md hover:shadow-lg transition-shadow duration-300">
                <img src="{{ asset('storage/' . $artikel->foto_kegiatan) }}" class="w-full h-full max-h-[440px] object-cover shadow-inner rounded-xl brightness-[.98] hover:brightness-100 transition-all duration-300" alt="{{ $artikel->judul_kegiatan }}">
            </div>
        @endif

        <div class="bg-white p-7 sm:p-10 rounded-2xl border border-slate-200/80 shadow-sm hover:border-emerald-100 transition-colors duration-300">
            <article class="text-slate-600 text-left text-sm sm:text-base leading-relaxed whitespace-pre-line font-medium tracking-normal space-y-5 text-justify">
                {{ $artikel->konten_lengkap }}
            </article>
        </div>

        <div class="pt-6 border-t border-slate-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-500 bg-white p-5 rounded-xl">
            <p>Bagikan rilis berita resmi ini ke jejaring sosial Anda:</p>
            <div class="flex items-center gap-3">
                <span class="text-[10px] uppercase tracking-wider font-bold">Bagikan Artikel:</span>
                <a href="https://api.whatsapp.com/send?text={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 flex items-center justify-center transition-all group duration-300 hover:scale-105">
                    <i class="fa-brands fa-whatsapp text-lg group-hover:scale-110"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition-all group duration-300 hover:scale-105">
                    <i class="fa-brands fa-facebook-f text-sm group-hover:scale-110"></i>
                </a>
            </div>
        </div>

    </main>

</body>
</html>