<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tokoh->gelar }} {{ $tokoh->nama_masyayikh }} - Profil Tokoh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-700 antialiased text-xs">

    <div class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-3xl mx-auto px-4 h-14 flex items-center justify-between">
            <a href="{{ route('landing.index') }}" class="font-bold text-slate-700 hover:text-amber-600 flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <span class="font-bold text-slate-400">Profil Tokoh Pesantren</span>
        </div>
    </div>

    <main class="max-w-3xl mx-auto px-4 py-10">
        <article class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 md:p-8">
            <div class="flex flex-col items-center text-center border-b border-slate-100 pb-6 mb-6">
                <div class="w-32 h-32 rounded-full overflow-hidden shadow-md border-4 border-slate-50 mb-4">
                    <img src="{{ $tokoh->foto_masyayikh ? asset('storage/' . $tokoh->foto_masyayikh) : 'https://placehold.co/300?text=Avatar' }}" alt="{{ $tokoh->nama_masyayikh }}" class="w-full h-full object-cover">
                </div>
                <h1 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">{{ $tokoh->gelar }} {{ $tokoh->nama_masyayikh }}</h1>
                <p class="text-amber-600 font-bold uppercase text-[10px] tracking-wider mt-1.5 bg-amber-50 px-3 py-1 rounded-full border border-amber-100/50">{{ $tokoh->jabatan_pesantren ?? 'Dewan Guru' }}</p>
            </div>

            <div class="prose max-w-none text-slate-600 font-medium text-xs md:text-sm leading-relaxed space-y-4 whitespace-pre-line">
                {!! $tokoh->biografi_lengkap !!}
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-slate-400 font-semibold">
                <span>Bagikan Profil Biografi:</span>
                <div class="flex gap-2">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Baca Profil Biografi ' . $tokoh->gelar . ' ' . $tokoh->nama_masyayikh . ' - ' . url()->current()) }}" target="_blank" class="px-3 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 hover:bg-emerald-100 flex items-center gap-1.5 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="px-3 py-2 bg-blue-50 text-blue-700 rounded-xl border border-blue-100 hover:bg-blue-100 flex items-center gap-1.5 transition-colors">
                        <i class="fa-brands fa-facebook text-sm"></i> Facebook
                    </a>
                </div>
            </div>
        </article>
    </main>

</body>
</html>