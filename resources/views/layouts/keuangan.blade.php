<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Keuangan') - SIM Pesantren</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full flex overflow-hidden">

    <!-- SIDEBAR: Menggunakan konsep Emerald pekat seragam dengan Pelanggaran -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-emerald-900 text-white flex flex-col justify-between z-30 shadow-xl transform -translate-x-full transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:flex shrink-0">
        <div>
            <!-- Header Sidebar -->
            <div class="h-16 flex items-center justify-between px-6 bg-emerald-950 border-b border-emerald-800/50">
                <div class="flex items-center">
                    <img src="{{ asset('storage/' . $profil->logo_pesantren) }}" alt="Logo Ponpes" class="w-8 h-8 object-contain mr-2.5 rounded bg-emerald-900/40 p-0.5">
                    <span class="font-bold tracking-tight text-lg">SIM Pesantren</span>
                </div>
                <!-- Tombol Tutup Sidebar di Mobile -->
                <button id="close-sidebar" class="text-emerald-300 hover:text-white md:hidden">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <!-- Navigasi Menu Keuangan -->
            <nav class="mt-6 px-4 space-y-1">
                <a href="{{ route('admin.keuangan.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.keuangan.dashboard') ? 'bg-emerald-800 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50' }}">
                    <i class="fa-solid fa-chart-pie mr-3 text-base text-emerald-400"></i> Ringkasan Kas
                </a>
                <a href="{{ route('admin.keuangan.kas.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.keuangan.kas') ? 'bg-emerald-800 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50' }}">
                    <i class="fa-solid fa-book-open mr-3 text-base text-emerald-400"></i> Buku Kas Umum
                </a>
                <a href="{{ route('admin.keuangan.kategori.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.keuangan.kategori') ? 'bg-emerald-800 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50' }}">
                    <i class="fa-solid fa-tags mr-3 text-base text-emerald-400"></i> Kategori Transaksi
                </a>
                <a href="{{ route('admin.keuangan.spp.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.keuangan.spp') ? 'bg-emerald-800 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50' }}">
                    <i class="fa-solid fa-user-graduate mr-3 text-base text-emerald-400"></i> SPP Bulanan Santri
                </a>
                <a href="{{ route('admin.keuangan.iuran_lain.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.keuangan.iuran_lain') ? 'bg-emerald-800 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800/50' }}">
                    <i class="fa-solid fa-hand-holding-dollar mr-3 text-base text-emerald-400"></i> Pembayaran Non-SPP
                </a>
            </nav>
        </div>

        <!-- Bagian Informasi User Autentikasi -->
        <div class="p-4 bg-emerald-950/60 border-t border-emerald-800/40 flex items-center justify-between">
            <div class="flex items-center min-w-0 gap-3">
                <div class="w-9 h-9 bg-emerald-800 rounded-full flex items-center justify-center font-bold text-emerald-200 uppercase ring-2 ring-emerald-700 shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-emerald-400 font-bold uppercase tracking-wider">Bendahara</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="text-emerald-300 hover:text-red-400 p-2 rounded transition-colors" title="Keluar">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Latar Belakang saat Sidebar Mobile Terbuka -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 z-20 hidden md:hidden"></div>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header Atas (Navbar) -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10 shrink-0">
            <div class="flex items-center">
                <!-- Tombol Hamburger Aktif di Mobile -->
                <button id="open-sidebar" class="text-slate-500 hover:text-slate-600 md:hidden mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-base font-bold text-slate-800 tracking-tight">@yield('page_title')</h2>
            </div>
            <div class="text-xs text-slate-400 font-medium hidden sm:block">
                <i class="fa-regular fa-calendar-days mr-1.5"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </header>

        <!-- Area Isi Konten Halaman -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 bg-slate-50">
            <!-- Alert Notifikasi Flash Session -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-sm"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Script Kontrol Buka Tutup Menu Khas Mobile -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        openBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    </script>

</body>
</html>