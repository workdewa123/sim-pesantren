<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIM Pesantren</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full flex overflow-hidden">

    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 z-30 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-emerald-900 text-white flex flex-col justify-between z-40 shadow-xl 
        -translate-x-full transition-transform duration-300 ease-in-out
        md:relative md:translate-x-0 md:flex">
        
        <div>
            <div class="h-16 flex items-center justify-between px-5 bg-emerald-950 border-b border-emerald-800/50">
                <div class="flex items-center min-w-0">
                    <img src="{{ asset('storage/' . $profil->logo_pesantren) }}" alt="Logo Ponpes" class="w-8 h-8 object-contain mr-2.5 rounded bg-emerald-900/40 p-0.5">
                    <span class="font-bold tracking-tight text-base truncate">SIM Pesantren</span>
                </div>
                <button id="close-sidebar-btn" class="text-emerald-300 hover:text-white md:hidden focus:outline-none ml-2 shrink-0">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <nav class="mt-6 px-4 space-y-1 overflow-y-auto max-h-[calc(100vh-10rem)]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.dashboard') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center mr-3 text-emerald-400"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.dashboard') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center mr-3 text-emerald-400"></i>
                    Manajemen User
                </a>
                
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-emerald-300/60 uppercase tracking-wider">Pendaftaran</div>
                <a href="{{ route('admin.persetujuan.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.persetujuan.*') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-user-clock w-5 text-center mr-3 text-emerald-400"></i>
                    Persetujuan Baru
                </a>
                <a href="{{ route('admin.pendaftaran.link') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.pendaftaran.link') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-link w-5 text-center mr-3 text-emerald-400"></i>
                    Link Pendaftaran
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-emerald-300/60 uppercase tracking-wider">Data Master</div>
                <a href="{{ route('admin.santri.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.santri.*') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-user-graduate w-5 text-center mr-3 text-emerald-400"></i>
                    Data Santri
                </a>
                <a href="{{ route('admin.ustadz.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.ustadz.*') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-chalkboard-user w-5 text-center mr-3 text-emerald-400"></i>
                    Data Ustadz
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-150 {{ Route::is('admin.kelas.*') ? 'bg-emerald-800 text-white shadow-md' : 'text-emerald-100 hover:bg-emerald-800/40 hover:text-white' }}">
                    <i class="fa-solid fa-school w-5 text-center mr-3 text-emerald-400"></i>
                    Data Kelas
                </a>
            </nav>
        </div>

        <div class="p-4 bg-emerald-950 border-t border-emerald-800/50 flex items-center justify-between">
            <div class="flex items-center overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-emerald-700 flex items-center justify-center font-bold text-sm text-emerald-100 shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-xs font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-emerald-400 font-medium uppercase tracking-wider">Admin</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-emerald-300 hover:text-red-400 p-2 rounded transition-colors duration-150" title="Keluar dari Aplikasi">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden w-full">
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10 shrink-0">
            <div class="flex items-center overflow-hidden mr-2">
                <button id="open-sidebar-btn" class="text-slate-500 hover:text-slate-600 md:hidden mr-3 focus:outline-none p-1">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight truncate">@yield('page_title')</h2>
            </div>
            <div class="text-xs text-slate-400 font-medium whitespace-nowrap hidden sm:block">
                <i class="fa-regular fa-calendar-days mr-1.5"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.add('opacity-100');
            }, 20);
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.remove('opacity-100');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);
    </script>

</body>
</html>