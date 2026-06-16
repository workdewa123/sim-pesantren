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

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200/80 p-6 sm:p-8 text-center flex flex-col items-center">
        <img src="{{ asset('img/Logo_PPRA.jpg') }}" alt="Logo Ponpes" class="w-16 h-16 object-contain mb-5 rounded-xl bg-slate-50 p-1 border border-slate-200 shadow-sm">

        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl mb-4 animate-bounce shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        
        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Pendaftaran Berhasil!</h2>
        <p class="text-slate-500 text-xs mt-2 leading-relaxed">Data pendaftaran atas nama <strong class="text-slate-700">{{ $santri->nama_santri }}</strong> telah aman tersimpan ke dalam sistem database pondok pesantren.</p>

        <div class="mt-6 w-full text-left space-y-2">
            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider block"><i class="fa-solid fa-receipt text-emerald-600 mr-1"></i> Rincian Kewajiban Biaya Masuk</span>
            <div class="border border-slate-200 rounded-xl overflow-hidden bg-white text-xs">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold border-b border-slate-100 text-[10px] uppercase">
                            <th class="py-2 px-3">Komponen Biaya</th>
                            <th class="py-2 px-3 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @foreach($rincianBiaya as $item)
                        <tr>
                            <td class="py-2 px-3">{{ $item->nama_komponen }}</td>
                            <td class="py-2 px-3 text-right font-mono">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="py-2 px-3 italic">Iuran Bulanan (Pilihan Wali)</td>
                            <td class="py-2 px-3 text-right font-mono">Rp {{ number_format($santri->pilihan_biaya, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-emerald-50/50 text-emerald-950 font-bold border-t border-slate-200 text-xs">
                            <td class="py-2.5 px-3">Total Estimasi Awal</td>
                            <td class="py-2.5 px-3 text-right font-mono text-emerald-700 text-sm">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <p class="text-[10px] text-slate-400 italic mt-1">*Nominal di atas dapat berubah sewaktu-waktu sesuai ketentuan pengurus.</p>
        </div>

        <div class="mt-6 p-4 bg-slate-50 border border-slate-200 rounded-xl text-left space-y-2 text-xs text-slate-600 w-full">
            <p><strong>Langkah Selanjutnya:</strong></p>
            <ol class="list-decimal list-inside space-y-1.5 text-slate-500 text-[11px]">
                <li>Unduh formulir pendaftaran & rincian biaya di bawah ini.</li>
                <li>Bawa lembar cetak fisik tersebut saat verifikasi ke kantor pondok.</li>
                <li>Lampirkan fotokopi berkas fisik asli KK dan Akte Kelahiran.</li>
            </ol>
        </div>

        <div class="mt-6 space-y-2.5 w-full text-xs">
            <a href="{{ route('pendaftaran.cetak', ['id' => $santri->id]) }}" 
               class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-4 rounded-xl transition-all duration-150 shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Unduh Formulir Biodata (PDF)
            </a>

            <a href="{{ route('pendaftaran.cetak_biaya', ['id' => $santri->id]) }}" 
               class="w-full bg-white hover:bg-slate-50 text-slate-700 font-bold py-3 px-4 rounded-xl border border-slate-200 transition-all duration-150 shadow-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-download text-emerald-600"></i> Unduh Rincian Biaya Masuk (PDF)
            </a>
            <a href="/" class="block text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors pt-2 mx-auto"> kembali ke Beranda </a>

        </div>
    </div>

</body>
</html> 
