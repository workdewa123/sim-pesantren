<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di {{ $profil->nama_pesantren ?? 'Pondok Pesantren' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Animasi Kustom untuk Fade-In Up */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-800 selection:text-white">

    <nav class="fixed top-0 inset-x-0 bg-white/80 backdrop-blur-md z-50 border-b border-slate-100/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                @if($profil && $profil->logo_pesantren)
                    <img src="{{ asset('storage/' . $profil->logo_pesantren) }}" alt="Logo" class="h-11 w-11 object-contain">
                @else
                    <div class="h-11 w-11 bg-emerald-800 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-sm">P</div>
                @endif
                <span class="font-extrabold text-sm tracking-tight text-slate-900 uppercase max-w-xs leading-tight">
                    {{ $profil->nama_pesantren ?? 'Pesantren Digital' }}
                </span>
            </a>
            
            <div class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600">
                <a href="#beranda" class="hover:text-emerald-800 transition-colors duration-200">Beranda</a>
                <a href="#profil" class="hover:text-emerald-800 transition-colors duration-200">Profil</a>
                <a href="#visi-misi" class="hover:text-emerald-800 transition-colors duration-200">Visi & Misi</a>
                <a href="#kegiatan" class="hover:text-emerald-800 transition-colors duration-200">Kegiatan</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-300">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-emerald-800 hover:bg-emerald-900 hover:scale-105 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-800/10 transition-all duration-300">Sistem Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="beranda" class="pt-32 pb-20 px-6 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center min-h-[85vh] animate-fade-in-up">
        <div class="lg:col-span-7 space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-100 rounded-full text-emerald-800 text-[11px] font-bold tracking-wide uppercase">
                <i class="fa-solid fa-star-and-crescent text-xs animate-pulse"></i> Portal Informasi Resmi
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                Membentuk Generasi Qur'ani, Berakhlak Mulia & <span class="text-emerald-800 relative">Unggul Berteknologi<span class="absolute bottom-1 left-0 w-full h-1 bg-emerald-100/60 rounded-full"></span></span>
            </h1>
            <p class="text-slate-500 text-sm leading-relaxed max-w-xl font-medium">
                Selamat datang di platform digital resmi {{ $profil->nama_pesantren ?? 'Pondok Pesantren kami' }}. Kami berkomitmen menyelenggarakan pendidikan kepesantrenan salafiyah maupun modern secara profesional dan akuntabel.
            </p>
            <div class="pt-2 flex flex-wrap gap-3">
                <a href="#profil" class="px-6 py-3 bg-slate-950 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition-all shadow-sm">Pelajari Profil Kami</a>
                @if($profil && $profil->whatsapp_kontak)
                    <a href="https://wa.me/62{{ $profil->whatsapp_kontak }}" target="_blank" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold rounded-xl transition-all flex items-center gap-2 group">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-base group-hover:scale-110 transition-transform"></i> Hubungi Humas
                    </a>
                @endif
            </div>
        </div>
        <div class="lg:col-span-5 relative flex justify-center group">
            <div class="absolute -inset-4 bg-emerald-800/10 rounded-3xl blur-2xl group-hover:bg-emerald-800/20 transition-colors duration-500"></div>
            <div class="relative bg-white p-4 rounded-3xl shadow-xl border border-slate-100 w-full max-w-sm hover:skew-y-1 transition-transform duration-500">
                <img src="{{ asset('img/Logo_PPRA.jpg') }}" class="w-full h-80 object-cover rounded-2xl shadow-inner transition-all duration-300 group-hover:brightness-105" alt="Santri Belajar">
            </div>
        </div>
    </section>

    <section class="bg-emerald-900 text-white py-12 px-6">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-1.5 p-4 rounded-xl hover:bg-white/5 transition-colors group">
                <p class="text-emerald-400 text-base mb-1 group-hover:scale-110 transition-transform"><i class="fa-solid fa-user-graduate"></i></p>
                <p class="text-3xl font-extrabold tracking-tight">{{ $totalSantri ?? 0 }}</p>
                <p class="text-emerald-200/80 text-[11px] font-semibold uppercase tracking-wider">Santri Aktif</p>
            </div>
            <div class="space-y-1.5 p-4 rounded-xl hover:bg-white/5 transition-colors group">
                <p class="text-emerald-400 text-base mb-1 group-hover:scale-110 transition-transform"><i class="fa-solid fa-chalkboard-user"></i></p>
                <p class="text-3xl font-extrabold tracking-tight">12</p>
                <p class="text-emerald-200/80 text-[11px] font-semibold uppercase tracking-wider">Asatidzah / Pengajar</p>
            </div>
            <div class="space-y-1.5 p-4 rounded-xl hover:bg-white/5 transition-colors group">
                <p class="text-emerald-400 text-base mb-1 group-hover:scale-110 transition-transform"><i class="fa-solid fa-mosque"></i></p>
                <p class="text-3xl font-extrabold tracking-tight">8</p>
                <p class="text-emerald-200/80 text-[11px] font-semibold uppercase tracking-wider">Komplek Madrosah</p>
            </div>
            <div class="space-y-1.5 p-4 rounded-xl hover:bg-white/5 transition-colors group">
                <p class="text-emerald-400 text-base mb-1 group-hover:scale-110 transition-transform"><i class="fa-solid fa-people-carry-box"></i></p>
                <p class="text-3xl font-extrabold tracking-tight">1500+</p>
                <p class="text-emerald-200/80 text-[11px] font-semibold uppercase tracking-wider">Alumni Tersebar</p>
            </div>
        </div>
    </section>

    <section id="profil" class="py-24 px-6 max-w-5xl mx-auto space-y-8">
        <div class="text-center max-w-xl mx-auto space-y-2 animate-fade-in-up">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Mengenal Lebih Dekat</h2>
            <div class="w-12 h-1 bg-emerald-800 mx-auto rounded-full mt-2"></div>
        </div>
        <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm space-y-5 hover:border-emerald-100 transition-colors duration-300">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2.5"><i class="fa-solid fa-book-open-reader text-emerald-700"></i>Sejarah & Kilasan Pendirian</h3>
            <p class="text-slate-600 text-xs leading-relaxed whitespace-pre-line text-justify font-medium">
                {{ $profil->sejarah_singkat ?? 'Informasi sejarah singkat pondok belum diisi oleh Tim Media.' }}
            </p>
        </div>
    </section>

    <section id="visi-misi" class="py-20 px-6 bg-slate-100/80 border-y border-slate-200/50">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 text-xs">
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4 hover:border-emerald-100/50 transition-colors group">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-800 border border-emerald-100/50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-eye text-base"></i></div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Visi Utama Lembaga</h3>
                <p class="text-slate-600 leading-relaxed font-medium">{{ $profil->visi ?? 'Visi belum diatur.' }}</p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4 hover:border-amber-100/50 transition-colors group">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-800 border border-amber-100/50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-list-check text-base"></i></div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Misi Perjuangan</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line font-medium text-justify">{{ $profil->misi ?? 'Misi belum diatur.' }}</div>
            </div>
        </div>
    </section>

    <section id="kegiatan" class="py-24 px-6 max-w-7xl mx-auto space-y-12">
        <div class="text-center max-w-xl mx-auto space-y-2 animate-fade-in-up">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Kabar & Agenda Kegiatan Santri</h2>
            <p class="text-slate-400 text-xs font-medium">Ikuti rilis berita, dokumentasi, dan transformasi agenda harian di pondok kami.</p>
            <div class="w-12 h-1 bg-emerald-800 mx-auto rounded-full mt-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            @forelse($kegiatan as $row)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition-all group duration-300">
                <div class="h-44 bg-slate-100 overflow-hidden relative">
                    @if($row->foto_kegiatan)
                        <img src="{{ asset('storage/' . $row->foto_kegiatan) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-95 group-hover:brightness-100">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">No Image Preview</div>
                    @endif
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2.5">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><i class="fa-regular fa-calendar mr-1.5"></i> {{ \Carbon\Carbon::parse($row->tanggal_kegiatan)->translatedFormat('d M Y') }}</p>
                        <h4 class="font-extrabold text-sm text-slate-900 tracking-tight leading-snug line-clamp-2 group-hover:text-emerald-800 transition-colors">{{ $row->judul_kegiatan }}</h4>
                        <p class="text-slate-500 leading-relaxed line-clamp-3 font-medium">{{ $row->deskripsi_singkat }}</p>
                    </div>
                    <a href="{{ route('landing.kegiatan.detail', $row->slug) }}" class="pt-2 font-bold text-emerald-800 hover:text-emerald-950 flex items-center gap-1.5 transition-all group">
                        Baca Selengkapnya <i class="fa-solid fa-arrow-right-long text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 p-12 text-center bg-white border border-slate-200 text-slate-400 rounded-2xl shadow-inner font-medium animate-pulse">
                Belum ada dokumentasi rilis kegiatan publikasi saat ini.
            </div>
            @endforelse
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 text-xs py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 pb-8 border-b border-slate-800">
            <div class="space-y-4 flex flex-col items-center md:items-start text-center md:text-left">
               
                <h4 class="font-extrabold text-sm tracking-tight text-white uppercase">{{ $profil->nama_pesantren ?? 'Pesantren' }}</h4>
                
                <a href="https://maps.app.goo.gl/ZziYFjjpPW9YNbqM9" target="_blank" class="leading-relaxed text-slate-400 hover:text-white flex items-start gap-2.5 group">
                    <i class="fa-solid fa-location-dot text-emerald-400 mt-1 shrink-0 group-hover:scale-110 transition-transform"></i>
                    <span class="group-hover:underline">
                        {{ $profil->alamat ?? 'Jl. Kyai Ghozali No.138, Tegalpsangan, Pakiskembar, Kec. Pakis, Kabupaten Malang, Jawa Timur 65154' }}
                    </span>
                </a>
            </div>
            <div class="space-y-3.5 flex flex-col items-center md:items-start">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Jejaring Sosial Resmi</h4>
                <div class="flex gap-5 text-xl pt-1">
                    @if($profil && $profil->instagram_link)<a href="{{ $profil->instagram_link }}" target="_blank" class="hover:text-amber-600 transition-colors"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($profil && $profil->facebook_link)<a href="{{ $profil->facebook_link }}" target="_blank" class="hover:text-blue-500 transition-colors"><i class="fa-brands fa-facebook"></i></a>@endif
                    @if($profil && $profil->youtube_link)<a href="{{ $profil->youtube_link }}" target="_blank" class="hover:text-rose-500 transition-colors"><i class="fa-brands fa-youtube"></i></a>@endif
                </div>
            </div>
            <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Kontak & Bantuan</h4>
                <p class="text-slate-400 leading-relaxed font-medium">Hubungi admin pendaftaran jika tautan registrasi formulir bermasalah atau untuk informasi kehumasan lebih lanjut.</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-6 text-center text-[11px] text-slate-500 font-medium tracking-tight leading-relaxed">
            © {{ date('Y') }} {{ $profil->nama_pesantren ?? 'Pesantren App' }}. Seluruh Hak Cipta Dilindungi. <br>
            Sistem Informasi Manajemen Terintegrasi Pondok Pesantren.
        </div>
    </footer>

</body>
</html>