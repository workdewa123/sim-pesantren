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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .tunggu-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease-out !important;
        }

        /* Keadaan aktif setelah terdeteksi scroll */
        .muncul-scroll {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
</head>

<body class="bg-black text-slate-800 antialiased selection:bg-blue-800 selection:text-white">

    <!-- ===== LOADING SCREEN ===== -->
    <div id="loading-screen"
        class="fixed inset-0 z-[9999] bg-black flex flex-col items-center justify-center gap-8 transition-opacity duration-700">

        <!-- Logo -->
        <div class="flex flex-col items-center gap-5 animate-fade-in-up">
            <img src="{{ asset('img/logo.webp') }}" alt="Logo"
                class="w-24 h-24 object-contain drop-shadow-2xl rounded-2xl">

            <div class="text-center space-y-1">
                <p class="text-white font-black text-xl tracking-tight uppercase">CV Lintas Tech</p>
                <p
                    class="text-2xl font-black bg-gradient-to-r from-purple-400 to-violet-600 bg-clip-text text-transparent uppercase tracking-tight">
                    Artomoro
                </p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-56 h-[3px] bg-white/10 rounded-full overflow-hidden">
            <div id="loading-bar"
                class="h-full w-0 bg-gradient-to-r from-purple-500 to-violet-500 rounded-full transition-all ease-out"
                style="transition-duration: 0ms;">
            </div>
        </div>

        <!-- Label -->
        <p id="loading-label" class="text-slate-500 text-[11px] font-semibold uppercase tracking-widest">
            Memuat halaman...
        </p>
    </div>
    <!-- ===== END LOADING SCREEN ===== -->

    <nav
        class="fixed left-1/2 -translate-x-1/2 z-50 w-full bg-white/70 backdrop-blur-xl border border-white/20 shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-500">

        <div class="h-16 px-6 flex items-center">

            <!-- Logo -->
            <div class="flex items-center gap-3 flex-1">
                <img src="{{ asset('img/logo.webp') }}" class="h-10 w-10 object-contain">

                <span class="font-bold text-sm tracking-tight text-slate-900">
                    CV Lintas Tech
                </span>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda" class="text-sm font-medium text-slate-600 hover:text-black transition">
                    Beranda
                </a>

                <a href="#profil" class="text-sm font-medium text-slate-600 hover:text-black transition">
                    Profil
                </a>

                <a href="#visi-misi" class="text-sm font-medium text-slate-600 hover:text-black transition">
                    Visi Misi
                </a>

                <a href="#kegiatan" class="text-sm font-medium text-slate-600 hover:text-black transition">
                    Kegiatan
                </a>
            </div>

            <!-- CTA -->
            <div class="flex-1 flex justify-end">
                <a href="#kontak" class="px-5 py-2 rounded-xl
                bg-black text-white text-sm font-semibold
                hover:bg-slate-800 transition">
                    Hubungi Kami
                </a>
            </div>

        </div>
    </nav>

    <section id="beranda" class="min-h-screen flex flex-col items-center justify-center px-6 text-center">

        <!-- Logo -->
        <div class="mb-8 p-6">
            <img src="{{ asset('img/logo.webp') }}" alt="Logo CV Lintas Tech"
                class="w-40 md:w-52 object-contain drop-shadow-2xl">
        </div>

        <!-- Judul -->
        <div class="space-y-2">
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight">
                CV LINTAS TECH
            </h1>

            <h2
                class="text-5xl md:text-7xl font-black bg-gradient-to-r from-purple-400 to-violet-600 bg-clip-text text-transparent">
                ARTOMORO
            </h2>
        </div>

        <!-- Subjudul -->
        <p class="mt-10 text-lg md:text-2xl text-blue-400 font-medium ">
            Solusi Digital dan Teknologi Terpercaya
        </p>

    </section>

    <br>
        <br>

    <section id="profil" class="tunggu-scroll py-12 px-6 mx-auto max-w-7xl space-y-12 bg-white rounded-lg">
        <div class="text-center max-w-xl mx-auto space-y-2 animate-fade-in-up">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight bottom-4">Profil perusahaan</h2>
            <div class="w-12 h-1 bg-blue-300 mx-auto rounded-full mt-2"></div>
        </div>
        <div
            class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-100 transition-colors duration-300 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2.5">Tentang Kami</h3>
                <p class="text-slate-600 text-xs leading-relaxed whitespace-pre-line text-justify font-medium">
                    {{ $profil->sejarah_singkat ?? 'Informasi sejarah singkat CV Lintas Tech belum diisi oleh Tim Media.' }}
                </p>
            </div>

            {{--
            ubah berdasarkan tabel dari database
            --}}
            <div class="w-full h-full flex justify-center items-center">
                <img src="{{ asset('img/test.jpg') }}" alt="profil_perusahaan"
                    class="w-600 max-h-400 object-cover rounded-xl">
            </div>

        </div>
    </section>

    <br>
    <br>

    {{-- Section Layanan Utama --}}
    <section class="tunggu-scroll bg-[#0b1329] py-20 px-6 min-h-screen flex flex-col justify-center">
        <div class="max-w-6xl mx-auto w-full space-y-12">

            {{-- Judul Card --}}
            <div class="flex items-center gap-4">
                <div class="w-1.5 h-10 bg-blue-500 rounded-full"></div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Layanan Utama</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Card 1 --}}
                <div
                    class="tunggu-scroll bg-[#111c3a] p-8 rounded-2xl border border-slate-800/60 shadow-xl space-y-4 hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="text-blue-500 text-3xl group-hover:scale-110 transition-transform duration-300 inline-block">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Web Development</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-medium">
                        Pengembangan sistem informasi kustom berbasis Laravel, UI/UX modern, dan integrasi API yang
                        tangguh.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div
                    class="tunggu-scroll bg-[#111c3a] p-8 rounded-2xl border border-slate-800/60 shadow-xl space-y-4 hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="text-blue-500 text-3xl group-hover:scale-110 transition-transform duration-300 inline-block">
                        <i class="fa-solid fa-rocket"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Digital Marketing (SEO & SEM)</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-medium">
                        Meningkatkan visibilitas bisnis melalui optimasi mesin pencari organik (SEO) dan manajemen
                        kampanye iklan presisi (Google Ads).
                    </p>
                </div>

                {{-- Card 3 --}}
                <div
                    class="tunggu-scroll bg-[#111c3a] p-8 rounded-2xl border border-slate-800/60 shadow-xl space-y-4 hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="text-blue-500 text-3xl group-hover:scale-110 transition-transform duration-300 inline-block">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Content Creation & SMM</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-medium">
                        Produksi konten kreatif dan optimasi media sosial (khususnya TikTok & IG Reels) untuk
                        memaksimalkan <span class="italic text-slate-300">engagement</span> dan viralitas brand.
                    </p>
                </div>

                {{-- Card 4 --}}
                <div
                    class="tunggu-scroll bg-[#111c3a] p-8 rounded-2xl border border-slate-800/60 shadow-xl space-y-4 hover:border-blue-500/30 transition-all duration-300 group">
                    <div
                        class="text-blue-500 text-3xl group-hover:scale-110 transition-transform duration-300 inline-block">
                        <i class="fa-solid fa-server"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white tracking-wide">Infrastructure</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-medium">
                        Penyediaan Hosting SSD performa tinggi, Domain profesional, serta setup keamanan dan analitik
                        web komprehensif.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- daftar Website --}}
    <section id="kegiatan" class="py-24 px-6 max-w-7xl mx-auto space-y-12">
        <div class="text-center max-w-xl mx-auto space-y-2 animate-fade-in-up">
            <h2 class="text-2xl font-black text-white tracking-tight">Daftar Website Yang Pernah Dibuat Oleh Kami
            </h2>
            <div class="w-12 h-1 bg-blue-300 mx-auto rounded-full mt-2"></div>
        </div>

        {{-- CARD 1 --}}
        <div
            class="tunggu-scroll bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-100 transition-colors duration-300 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2.5">Contoh Website 1</h3>
                <p class="text-slate-600 text-xs leading-relaxed whitespace-pre-line text-justify font-medium">
                    {{ $profil->sejarah_singkat ?? 'Informasi sejarah singkat CV Lintas Tech belum diisi oleh Tim Media.' }}
                </p>
            </div>
            <div class="w-full h-full flex justify-center items-center md:order-first">
                <img src="{{ asset('img/test.jpg') }}" alt="profil_perusahaan"
                    class="w-full max-h-72 object-cover rounded-xl">
            </div>
        </div>

        {{-- CARD 2 --}}
        <div
            class="tunggu-scroll bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-100 transition-colors duration-300 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2.5">Contoh Website 2</h3>
                <p class="text-slate-600 text-xs leading-relaxed whitespace-pre-line text-justify font-medium">
                    {{ $profil->sejarah_singkat ?? 'Informasi sejarah singkat CV Lintas Tech belum diisi oleh Tim Media.' }}
                </p>
            </div>
            <div class="w-full h-full flex justify-center items-center md:order-first">
                <img src="{{ asset('img/test.jpg') }}" alt="profil_perusahaan"
                    class="w-full max-h-72 object-cover rounded-xl">
            </div>
        </div>

        {{-- CARD 3 --}}
        <div
            class="tunggu-scroll bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-sm hover:border-emerald-100 transition-colors duration-300 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2.5">Contoh Website 3</h3>
                <p class="text-slate-600 text-xs leading-relaxed whitespace-pre-line text-justify font-medium">
                    {{ $profil->sejarah_singkat ?? 'Informasi sejarah singkat CV Lintas Tech belum diisi oleh Tim Media.' }}
                </p>
            </div>
            <div class="w-full h-full flex justify-center items-center md:order-first">
                <img src="{{ asset('img/test.jpg') }}" alt="profil_perusahaan"
                    class="w-full max-h-72 object-cover rounded-xl">
            </div>
        </div>
    </section>

    {{-- media sosial --}}
    <section id="profil" class="tunggu-scroll py-12 px-6 mx-auto max-w-7xl">
        <div
            class="bg-white p-8 md:p-12 rounded-2xl border border-slate-800/60 shadow-xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <div class="space-y-6">
                <div class="tunggu-scroll space-y-0">
                    <p class="text-blue-600 text-sm md:text-base font-semibold tracking-wide">
                        Creative & Social Media Division
                    </p>
                    <h3 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        Optimasi & Tren Digital
                    </h3>
                </div>

                <p class="tunggu-scroll text-slate-600 text-sm leading-relaxed font-normal">
                    Kami mengoptimasi kehadiran brand Anda di media sosial, dengan spesialisasi pada algoritma dan tren
                    <span class="font-bold text-blue-600">TikTok</span> yang sedang hits, untuk menciptakan konten viral
                    yang berkonversi.
                </p>

                {{-- DIISI BERDASARKAN DATABASE --}}
                <div class="space-y-3">
                    <h4 class="tunggu-scroll text-sm font-bold text-blue-600 tracking-wide">Affiliated Creators:</h4>
                    <div class="flex flex-wrap gap-3">
                        <span
                            class="px-4 py-2 bg-slate-800 border  rounded-xl text-xs font-semibold text-slate-300 transition-colors hover:bg-slate-700/50 cursor-pointer">@anis_khaeriyah</span>
                        <span
                            class="px-4 py-2 bg-slate-800 border  rounded-xl text-xs font-semibold text-slate-300 transition-colors hover:bg-slate-700/50 cursor-pointer">@apakatamiii</span>
                        <span
                            class="px-4 py-2 bg-slate-800 border  rounded-xl text-xs font-semibold text-slate-300 transition-colors hover:bg-slate-700/50 cursor-pointer">@uhuy</span>
                    </div>
                </div>
            </div>

            <div
                class="tunggu-scroll w-full h-full min-h-[300px] flex justify-center items-center rounded-xl bg-slate-800/30 border border-slate-700/20 overflow-hidden">
                <img src="{{ asset('img/test.jpg') }}" alt="Foto Produksi Konten TikTok/Sosmed"
                    class="w-full h-full min-h-[300px] max-h-[450px] object-cover transition-transform duration-500 hover:scale-105">
            </div>

        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 text-xs py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 pb-8 border-b border-slate-800">
            <div class="space-y-4 flex flex-col items-center md:items-start text-center md:text-left">

                <h4 class="font-extrabold text-sm tracking-tight text-white uppercase">
                    {{ $profil->nama_pesantren ?? 'Pesantren' }}
                </h4>

                <a href="https://maps.app.goo.gl/ZziYFjjpPW9YNbqM9" target="_blank"
                    class="leading-relaxed text-slate-400 hover:text-white flex items-start gap-2.5 group">
                    <i
                        class="fa-solid fa-location-dot text-emerald-400 mt-1 shrink-0 group-hover:scale-110 transition-transform"></i>
                    <span class="group-hover:underline">
                        {{ $profil->alamat ?? 'Jl. Kyai Ghozali No.138, Tegalpsangan, Pakiskembar, Kec. Pakis, Kabupaten Malang, Jawa Timur 65154' }}
                    </span>
                </a>
            </div>
            <div class="space-y-3.5 flex flex-col items-center md:items-start">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Jejaring Sosial Resmi</h4>
                <div class="flex gap-5 text-xl pt-1">
                    @if($profil && $profil->instagram_link)<a href="{{ $profil->instagram_link }}" target="_blank"
                    class="hover:text-amber-600 transition-colors"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($profil && $profil->facebook_link)<a href="{{ $profil->facebook_link }}" target="_blank"
                    class="hover:text-blue-500 transition-colors"><i class="fa-brands fa-facebook"></i></a>@endif
                    @if($profil && $profil->youtube_link)<a href="{{ $profil->youtube_link }}" target="_blank"
                    class="hover:text-rose-500 transition-colors"><i class="fa-brands fa-youtube"></i></a>@endif
                </div>
            </div>
            <div class="space-y-3 flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Kontak & Bantuan</h4>
                <p class="text-slate-400 leading-relaxed font-medium">Hubungi admin pendaftaran jika tautan registrasi
                    formulir bermasalah atau untuk informasi kehumasan lebih lanjut.</p>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto px-6 pt-6 text-center text-[11px] text-slate-500 font-medium tracking-tight leading-relaxed">
            © {{ date('Y') }} {{ $profil->nama_pesantren ?? 'Pesantren App' }}. Seluruh Hak Cipta Dilindungi. <br>
            Sistem Informasi Manajemen Terintegrasi Pondok Pesantren.
        </div>
    </footer>

</body>

<script>
    // ===== LOADING SCREEN LOGIC =====
    const loadingScreen = document.getElementById('loading-screen');
    const loadingBar = document.getElementById('loading-bar');
    const loadingLabel = document.getElementById('loading-label');

    let currentPct = 0;   // posisi bar saat ini — tidak boleh mundur
    let dismissed = false; // guard: dismissLoading hanya boleh jalan SEKALI

    // Fungsi set bar — menolak nilai yang lebih kecil dari posisi sekarang
    function setBar(pct, label) {
        if (pct <= currentPct) return;
        currentPct = pct;
        loadingBar.style.transitionDuration = '500ms';
        loadingBar.style.width = pct + '%';
        if (label) loadingLabel.textContent = label;
    }

    // Animasi simulasi progress — delay KUMULATIF dari awal (bukan berantai)
    // Bar berhenti MAKSIMAL di 85%, tidak akan ke 100 sebelum window.load terpicu
    setTimeout(() => setBar(20, 'Memuat aset...'), 200);
    setTimeout(() => setBar(45, 'Mengunduh konten...'), 700);
    setTimeout(() => setBar(70, 'Menyiapkan tampilan...'), 1400);
    setTimeout(() => setBar(85, 'Hampir selesai...'), 2200);

    function dismissLoading() {
        if (dismissed) return; // tolak pemanggilan ganda
        dismissed = true;

        // Paksa 100% dulu, baru fade out
        setBar(100, 'Selesai!');

        setTimeout(() => {
            loadingScreen.style.transition = 'opacity 0.7s ease';
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                if (loadingScreen.parentNode) loadingScreen.remove();
            }, 700);
        }, 500);
    }

    // HANYA window.load yang boleh trigger dismiss utama
    window.addEventListener('load', dismissLoading);

    // Fallback darurat: jika setelah 15 detik load belum selesai (koneksi sangat lambat)
    setTimeout(() => { if (!dismissed) dismissLoading(); }, 15000);

    // ===== LOGIK ANIMASI ON SCROLL =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // Tambahkan class animasi ketika elemen masuk ke area layar
                entry.target.classList.add('muncul-scroll');
            }
        });
    }, {
        // Memberikan offset agar animasi baru terpicu saat elemen 10% masuk ke layar
        threshold: 0.1
    });

    // Mengambil semua elemen yang ingin diberi efek scroll animation
    const elemenAnimasi = document.querySelectorAll('.tunggu-scroll');
    elemenAnimasi.forEach((el) => observer.observe(el));

    // ===== NAVBAR LOGIC =====
    const navbar = document.querySelector("nav");

    function updateNavbar() {
        if (window.scrollY > 10) {
            navbar.classList.remove("opacity-0", "pointer-events-none");
        } else {
            navbar.classList.add("opacity-0", "pointer-events-none");
        }
    }

    // Cek setiap kali user scroll
    window.addEventListener("scroll", updateNavbar);

    // Paksa scroll ke atas + evaluasi state navbar saat halaman selesai dimuat
    // Ini menangani kasus browser restore posisi scroll setelah refresh
    window.addEventListener("load", () => {
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual'; // nonaktifkan auto-restore scroll browser
        }
        window.scrollTo(0, 0);
        updateNavbar();
    });
</script>

</html>