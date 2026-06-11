<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Manajemen Pesantren - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[550px] md:min-h-[580px]">
        
        <div class="w-full md:w-1/2 bg-gradient-to-br from-emerald-800 to-teal-950 p-6 sm:p-8 md:p-10 flex flex-col justify-between text-white select-none">
            <div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold uppercase tracking-wider bg-emerald-700/50 px-3 py-1.5 rounded-full backdrop-blur-sm">Aplikasi Manajemen</span>
                    <a href="/home" class="hidden md:flex items-center gap-1.5 text-xs text-emerald-300 hover:text-white transition-colors duration-200">
                        <i class="fa-solid fa-arrow-left"></i> Beranda
                    </a>
                </div>
                
                <div class="mt-6 mb-4 flex items-center gap-4">
                    <img src="" alt="Logo Ponpes Al-Ghozali" class="w-14 h-14 sm:w-16 sm:h-16 object-contain rounded-lg bg-emerald-900/30 p-1 border border-emerald-600/30">
                    <div>
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold leading-tight tracking-tight">SIM Pesantren</h1>
                        <p class="text-emerald-300 text-xs font-medium">Al-Ghozali Pakiskembar</p>
                    </div>
                </div>

                <p class="text-emerald-200/90 text-xs sm:text-sm mt-2 leading-relaxed">Platform digital terintegrasi untuk pengelolaan administrasi, kedisiplinan santri, dan keuangan kantor pondok pesantren.</p>
            </div>
            
            <div class="mt-6 md:mt-0 border-t border-emerald-700/30 pt-4 md:border-none md:pt-0">
                <p class="text-[11px] text-emerald-300/80">© {{ date('Y') }} Sistem Informasi Manajemen Pesantren. Hak Cipta Dilindungi.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-6 sm:p-8 md:p-10 lg:p-12 flex flex-col justify-center relative">
            
            <div class="flex items-center justify-between mb-6 md:hidden bg-slate-50 p-3 rounded-xl border border-slate-100">
                <div class="flex items-center gap-3">
                    <img src="" alt="Logo Ponpes Al-Ghozali" class="w-10 h-10 object-contain">
                    <div>
                        <h3 class="text-xs font-bold text-slate-800">SIM Pesantren</h3>
                        <p class="text-[10px] text-slate-500">Al-Ghozali Pakiskembar</p>
                    </div>
                </div>
                <a href="/home" class="flex items-center gap-1 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-emerald-50 px-2.5 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-house text-[11px]"></i> Home
                </a>
            </div>

            <div class="mb-5 sm:mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Silakan masuk menggunakan akun staf Anda yang terdaftar.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Alamat Email Staf</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-lg border @error('email') border-red-400 bg-red-50/30 @else border-slate-200 @enderror text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all duration-200" 
                           placeholder="nama@pesantren.com">
                    @error('email')
                        <p class="text-red-500 text-[11px] mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3.5 py-2.5 sm:px-4 sm:py-3 rounded-lg border @error('email') border-red-400 bg-red-50/30 @else border-slate-200 @enderror text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all duration-200" 
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between pt-0.5">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 accent-emerald-600 cursor-pointer">
                        <label for="remember" class="ml-2 block text-xs sm:text-sm text-slate-600 cursor-pointer select-none">Ingat saya</label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-semibold py-2.5 sm:py-3 px-4 rounded-lg text-xs sm:text-sm shadow-md shadow-emerald-700/10 hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                        Masuk ke Dasbor
                    </button>
                </div>
            </form>

            <div class="hidden md:block text-center mt-6">
                <a href="{{ route('landing.index') }}" class="text-xs font-medium text-slate-400 hover:text-emerald-700 transition-colors duration-150">
                    <i class="fa-solid fa-house-chimney text-[10px] mr-1"></i> Kembali ke Halaman Utama Utama
                </a>
            </div>
        </div>

    </div>

</body>
</html>