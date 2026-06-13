<!DOCTYPE html>
<html lang="id" class="h-full bg-neutral selection:bg-primary selection:text-neutral">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo.webp') }}" type="image/webp">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FFFFFF',
                        secondary: '#A3A3A3',
                        tertiary: '#374151',
                        neutral: '#000000',
                        surface: '#111111',
                        'primary-90': '#F5F5F5',
                        'neutral-80': '#1A1A1A',
                    },
                    borderRadius: {
                        'framer-sm': '4px',
                        'framer-md': '8px',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .headline-md {
            font-size: clamp(1.5rem, 3vw, 2.18rem);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .body-md {
            font-size: 0.93rem;
            line-height: 1.53;
            letter-spacing: -0.01em;
        }
    </style>
</head>

<body class="h-full bg-neutral flex items-center justify-center p-4 sm:p-6 lg:p-8 font-sans antialiased text-primary">

    <div class="w-full max-w-md bg-surface border border-tertiary rounded-framer-md shadow-2xl overflow-hidden p-8 sm:p-10 flex flex-col justify-center">

        <div class="mb-8 flex items-center gap-4 justify-center md:justify-start">
            <img src="{{ asset('img/logo.webp') }}" alt="Logo Ponpes Al-Ghozali" class="w-12 h-12 object-contain rounded-framer-md bg-surface p-1 border border-tertiary">
            <div>
                <h1 class="text-xl font-extrabold leading-none tracking-tight text-primary uppercase">Lintas Tech</h1>
            </div>
        </div>

        <div class="mb-6 text-center md:text-left">
            <h2 class="headline-md text-primary uppercase">Selamat Datang Kembali</h2>
            <p class="text-secondary text-xs mt-1.5">Silakan masuk menggunakan akun staf Anda yang terdaftar.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-framer-sm bg-surface border @error('email') border-red-500 text-red-200 @else border-tertiary @enderror text-primary text-sm focus:outline-none focus:border-primary transition-all duration-200 placeholder-tertiary" 
                       placeholder="email@xxx.com">
                @error('email')
                    <p class="text-red-400 text-[11px] mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 rounded-framer-sm bg-surface border @error('email') border-red-500 @else border-tertiary @enderror text-primary text-sm focus:outline-none focus:border-primary transition-all duration-200 placeholder-tertiary" 
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 rounded border-tertiary bg-surface text-primary focus:ring-0 accent-primary cursor-pointer">
                    <label for="remember" class="ml-2 block text-xs text-secondary cursor-pointer select-none">Ingat saya</label>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full h-11 bg-primary text-neutral font-bold rounded-framer-sm hover:bg-primary-90 transition-colors uppercase tracking-widest text-xs shadow-lg">
                    Masuk
                </button>
            </div>
        </form>

        <div class="text-center mt-8 pt-4 border-t border-tertiary/30">
            <a href="{{ route('landing.index') }}" class="text-xs font-medium text-secondary hover:text-primary transition-colors duration-150 uppercase tracking-wider">
                Kembali
            </a>
        </div>

    </div>

</body>
</html>