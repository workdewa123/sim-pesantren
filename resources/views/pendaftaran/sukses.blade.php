<!DOCTYPE html>
<html lang="id" class="bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="py-12 px-4 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200/80 p-8 text-center flex flex-col items-center">
        <img src="{{ asset('img/Logo_PPRA.jpg') }}" alt="Logo Ponpes" class="w-16 h-16 object-contain mb-5 rounded-xl bg-slate-50 p-1 border border-slate-200 shadow-sm">

        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl mb-4 animate-bounce shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pendaftaran Berhasil!</h2>
        <p class="text-slate-500 text-sm mt-2 leading-relaxed">Data pendaftaran atas nama <strong class="text-slate-700">{{ $santri->nama_santri }}</strong> telah aman tersimpan ke dalam sistem database pondok pesantren.</p>

        <div class="mt-6 p-4 bg-slate-50 border border-slate-200 rounded-xl text-left space-y-2 text-xs text-slate-600 w-full">
            <p><strong>Langkah Selanjutnya:</strong></p>
            <ol class="list-decimal list-inside space-y-1.5 text-slate-500">
                <li>Unduh dan cetak dokumen berkas fisik di bawah ini.</li>
                <li>Bawa lembar cetak fisik tersebut saat verifikasi ke kantor pondok.</li>
                <li>Lampirkan fotokopi berkas fisik asli KK dan Akte Kelahiran.</li>
            </ol>
        </div>

        <div class="mt-8 space-y-3 w-full">
            <a href="{{ route('pendaftaran.cetak', ['id' => $santri->id]) }}" 
               class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-4 rounded-xl text-sm transition-all duration-150 shadow-md shadow-emerald-800/10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Unduh Lembar Formulir (PDF)
            </a>
            <a href="/" class="block text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors pt-2 mx-auto"> kembali ke Beranda </a>
        </div>
    </div>

</body>
</html>