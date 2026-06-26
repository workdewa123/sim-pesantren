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
        .scrollbar-thin::-webkit-scrollbar { height: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
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
                <a href="#masyayikh" class="hover:text-emerald-800 transition-colors duration-200">Masyayikh</a>
                <a href="#kegiatan" class="hover:text-emerald-800 transition-colors duration-200">Kegiatan</a>
                <a href="#pendaftaran" class="hover:text-emerald-800 transition-colors duration-200">Pendaftaran</a>
                <a href="#kontak" class="hover:text-emerald-800 transition-colors duration-200">Kontak</a>
                <a href="#lokasi" class="hover:text-emerald-800 transition-colors duration-200">Lokasi</a>
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

    <section class="max-w-7xl mx-auto px-6 py-20" id="masyayikh-section">
        <div class="text-center mb-16">
            <span class="text-amber-700 font-extrabold text-[11px] uppercase tracking-widest bg-amber-100/80 px-4 py-2 rounded-full border border-amber-200/50 shadow-sm">Sanad Keilmuan</span>
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mt-4 tracking-tight">Masyayikh & Dewan Guru</h2>
            <div class="w-12 h-1 bg-amber-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-slate-500 mt-4 text-sm max-w-md mx-auto leading-relaxed font-medium">Keteladanan bimbingan para pengasuh dan dewan guru dalam menjaga khazanah keilmuan syariat Islam.</p>
        </div>

        <div class="flex flex-nowrap gap-8 overflow-x-auto pb-6 snap-x snap-mandatory scroll-smooth scrollbar-thin" style="scrollbar-width: thin;">
            @forelse($masyayikh as $tokoh)
                <div class="flex flex-col items-center text-center group snap-start shrink-0 w-[260px] sm:w-[290px] md:w-[calc(33.333%-22px)] bg-white rounded-3xl border border-slate-100 p-6 shadow-sm hover:shadow-xl hover:border-amber-600/20 transition-all duration-300">
                    
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full border-2 border-dashed border-slate-200 group-hover:rotate-45 group-hover:border-amber-500 transition-all duration-700 p-1"></div>
                        
                        <a href="{{ route('landing.masyayikh.detail', $tokoh->slug) }}" class="block w-36 h-36 rounded-full overflow-hidden border-4 border-white shadow-md relative aspect-square shrink-0 z-10 m-1">
                            <img src="{{ $tokoh->foto_masyayikh ? asset('storage/' . $tokoh->foto_masyayikh) : 'https://placehold.co/300?text=Masyayikh' }}" 
                                alt="{{ $tokoh->nama_masyayikh }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </a>
                    </div>
                    
                    <div class="mt-5 flex flex-col items-center flex-grow w-full">
                        <span class="text-amber-700 font-extrabold text-[9px] uppercase tracking-wider bg-amber-50 px-3 py-1 rounded-full border border-amber-200/60 mb-2">
                            {{ $tokoh->jabatan_pesantren ?? 'Dewan Guru' }}
                        </span>
                        
                        <h4 class="font-black text-slate-800 text-sm group-hover:text-amber-600 transition-colors tracking-tight line-clamp-1 px-2">
                            <a href="{{ route('landing.masyayikh.detail', $tokoh->slug) }}">{{ $tokoh->gelar }} {{ $tokoh->nama_masyayikh }}</a>
                        </h4>
                        
                        <p class="text-slate-400 font-medium text-[11px] mt-2 line-clamp-3 px-2 leading-relaxed flex-grow">
                            {{ strip_tags($tokoh->biografi_lengkap) }}
                        </p>
                        
                        <a href="{{ route('landing.masyayikh.detail', $tokoh->slug) }}" class="mt-4 text-[10px] font-bold text-slate-600 group-hover:text-amber-600 flex items-center gap-1 transition-colors border-b border-slate-200 group-hover:border-amber-500 pb-0.5">
                            Lihat Biografi <i class="fa-solid fa-chevron-right text-[8px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto mb-3">
                        <i class="fa-solid fa-user-tie text-base"></i>
                    </div>
                    <h4 class="font-bold text-slate-700 text-xs">Data Masyayikh Kosong</h4>
                    <p class="text-slate-400 text-[11px] mt-0.5">Data profil pengasuh dewan guru belum dirilis oleh tim media.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section id="kegiatan" class="py-24 px-6 max-w-7xl mx-auto space-y-12">
        <div class="max-w-7xl mx-auto px-6 py-16" id="kegiatan-section">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-amber-600 font-bold text-xs uppercase tracking-wider bg-amber-50 px-3 py-1.5 rounded-full border border-amber-100/50">Warta Pondok</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 mt-3 tracking-tight">Kegiatan & Berita Terbaru</h2>
                    <p class="text-slate-500 mt-2 text-sm max-w-xl leading-relaxed font-medium">Ikuti terus perkembangan aktivitas harian santri, agenda hari besar, dan siaran pers resmi dari pondok pesantren.</p>
                </div>
            </div>

            <div class="flex flex-nowrap gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth scrollbar-thin" style="scrollbar-width: thin;">
                @forelse($kegiatan as $item)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-amber-600/10 transition-all duration-300 overflow-hidden flex flex-col group snap-start shrink-0 w-[280px] sm:w-[320px] md:w-[calc(33.333%-16px)]">
                        <div class="relative overflow-hidden aspect-[4/3] bg-slate-100 shrink-0">
                            <img src="{{ $item->foto_kegiatan ? asset('storage/' . $item->foto_kegiatan) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                alt="{{ $item->judul_kegiatan }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        
                        <div class="p-5 flex flex-col flex-grow text-xs">
                            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-semibold mb-3">
                                <span class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md">
                                    <i class="fa-regular fa-calendar text-slate-400"></i>
                                    {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->locale('id')->isoFormat('D MMMM Y') }}
                                </span>
                                <span class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md">
                                    <i class="fa-regular fa-user text-slate-400"></i>
                                    {{ $item->penulis }}
                                </span>
                            </div>
                            
                            <h3 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-amber-600 transition-colors line-clamp-2 tracking-tight">
                                {{ $item->judul_kegiatan }}
                            </h3>
                            
                            <p class="text-slate-500 text-[11px] mt-2.5 leading-relaxed font-medium line-clamp-2 flex-grow">
                                {{ $item->deskripsi_singkat }}
                            </p>
                            
                            <div class="pt-4 mt-4 border-t border-slate-50 flex items-center justify-between shrink-0">
                                <a href="{{ route('landing.kegiatan.detail', $item->slug) }}" class="text-xs font-bold text-slate-700 hover:text-amber-600 transition-colors flex items-center gap-1 group/btn cursor-pointer">
                                    Baca Selengkapnya
                                    <i class="fa-solid fa-arrow-right text-[10px] transform group-hover/btn:translate-x-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-12 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 mx-auto mb-3">
                            <i class="fa-regular fa-newspaper text-lg"></i>
                        </div>
                        <h4 class="font-bold text-slate-700 text-xs">Belum Ada Berita</h4>
                        <p class="text-slate-400 text-[11px] mt-0.5">Dokumentasi kegiatan resmi pondok pesantren belum dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-b from-slate-50 to-slate-100/50 border-y border-slate-200/60 py-20 relative overflow-hidden" id="pendaftaran-section">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-emerald-700 font-extrabold text-[11px] uppercase tracking-widest bg-emerald-100/80 px-4 py-2 rounded-full border border-emerald-200/50 shadow-sm">Penerimaan Santri Baru (PSB)</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-800 mt-4 tracking-tight">Alur & Tata Cara Pendaftaran</h2>
                <div class="w-12 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
                <p class="text-slate-500 mt-4 text-sm max-w-xl mx-auto leading-relaxed font-medium">Silakan ikuti 6 tahapan regulasi pendaftaran di bawah ini untuk bergabung menjadi santri baru di pondok pesantren.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">1</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Hubungi Admin / Humas</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Hubungi admin/humas via WhatsApp untuk meminta akses link formulir, atau kunjungi langsung kantor sekretariat pondok.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">2</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Pengisian Dokumen Online</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Lakukan pengisian data berkas santri secara online dengan teliti melalui halaman resmi pendaftaran yang diberikan pengurus.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">3</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Unduh Berkas Hasil</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Setelah data sukses tersimpan, unduh cetakan berkas kartu pendaftaran beserta rincian rujukan komponen biaya masuk.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">4</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Verifikasi Dokumen Fisik</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Bawa berkas cetak fisik formulir pendaftaran tersebut ke kantor administrasi pesantren untuk divalidasi oleh panitia.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">5</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Lampiran Berkas Asli</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Sertakan dokumen penunjang berupa lembar fotokopi Kartu Keluarga (KK) dan Akte Kelahiran calon santri baru.</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm flex gap-5 items-start group hover:border-emerald-600/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center font-black text-white text-base shadow-md shadow-emerald-600/20 shrink-0 group-hover:scale-110 transition-transform duration-300">6</div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm tracking-tight mb-1.5 group-hover:text-emerald-700 transition-colors">Pelunasan Administrasi</h4>
                        <p class="text-slate-500 text-[11px] leading-relaxed font-medium">Selesaikan proses pelunasan kontribusi biaya sesuai kesepakatan ketentuan instansi bendahara keuangan pondok.</p>
                    </div>
                </div>
            </div>
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