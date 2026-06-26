<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Rekap SPP Tahun {{ $tahun }} H</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { background-color: #fff; padding: 0; }
            .print-container { shadow: none; max-width: 100%; border: none; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans antialiased p-4 md:p-8">

    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden print-container">
        <div class="no-print px-6 py-4 bg-slate-50 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-slate-600">
                <i class="fa-solid fa-eye text-emerald-600 text-lg"></i>
                <span class="text-sm font-semibold">Mode Pratinjau Laporan</span>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl text-xs transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-print"></i> Cetak / Cetak PDF
                </button>
                <button onclick="window.close()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                    Tutup Tab
                </button>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <div class="text-center space-y-1">
                <h2 class="text-xl font-black text-slate-800 tracking-wide uppercase">REKAPITULASI PEMBAYARAN SPP SANTRI</h2>
                <p class="text-sm font-bold text-emerald-700">TAHUN HIJRIYAH: {{ $tahun }} H</p>
                <div class="w-16 h-1 bg-emerald-600 mx-auto mt-2 rounded-full"></div>
            </div>

            <div class="space-y-2">
                <h3 class="text-sm font-black text-slate-700 flex items-center gap-1.5 uppercase tracking-wider">
                    <span class="w-2 h-4 bg-emerald-600 rounded-sm"></span> A. Kelompok Santri Mukim
                </h3>
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-[11px]">
                        <thead>
                            <tr class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                                <th class="p-2.5 border-r border-slate-200 text-center w-10">NO</th>
                                <th class="p-2.5 border-r border-slate-200 min-w-[150px]">NAMA SANTRI</th>
                                @foreach($urutanBulan as $blnNum => $blnNama)
                                    <th class="p-2.5 border-r border-slate-200 text-center w-16 uppercase">{{ substr($blnNama, 0, 3) }}</th>
                                @endforeach
                                <th class="p-2.5 border-slate-200 text-center w-20">NOMINAL WAJIB</th>
                                @foreach($daftarIuranLain as $iuran)
                                    <th class="p-2.5 bg-amber-50 text-amber-900 border-l border-amber-200 text-center uppercase">{{ $iuran->nama_iuran }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @foreach($santriMukim as $index => $s)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-2 border-r border-slate-200 text-center font-medium">{{ $index + 1 }}</td>
                                    <td class="p-2 border-r border-slate-200 font-bold text-slate-800 uppercase">{{ $s->nama_santri }}</td>
                                    @foreach($urutanBulan as $blnNum => $blnNama)
                                        @php
                                            $lunas = isset($pembayaran[$s->id]) && $pembayaran[$s->id]->where('bulan', $blnNum)->first();
                                        @endphp
                                        <td class="p-2 border-r border-slate-200 text-center">
                                            @if($lunas)
                                                <span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-black rounded text-[9px]">LUNAS</span>
                                            @else
                                                <span class="text-slate-300 font-bold">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="p-2 border-slate-200 text-center font-bold">Rp {{ number_format($s->pilihan_biaya, 0, ',', '.') }}</td>
                                    @foreach($daftarIuranLain as $iuran)
                                        <td class="p-2 border-slate-200 text-center">
                                            @php
                                                $bayarLain = $pembayaranIuranLain->get($s->id)?->firstWhere('iuran_lain_id', $iuran->id);
                                            @endphp
                                            @if($bayarLain && $bayarLain->status_pembayaran == 'Lunas')
                                                <span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-black rounded text-[9px]">LUNAS</span>
                                            @else
                                                <span class="text-slate-300 font-bold">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-2 pt-4">
                <h3 class="text-sm font-black text-slate-700 flex items-center gap-1.5 uppercase tracking-wider">
                    <span class="w-2 h-4 bg-amber-500 rounded-sm"></span> B. Kelompok Santri Non-Mukim
                </h3>
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse text-[11px]">
                        <thead>
                            <tr class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                                <th class="p-2.5 border-r border-slate-200 text-center w-10">NO</th>
                                <th class="p-2.5 border-r border-slate-200 min-w-[150px]">NAMA SANTRI</th>
                                @foreach($urutanBulan as $blnNum => $blnNama)
                                    <th class="p-2.5 border-r border-slate-200 text-center w-16 uppercase">{{ substr($blnNama, 0, 3) }}</th>
                                @endforeach
                                <th class="p-2.5 border-slate-200 text-center w-20">NOMINAL WAJIB</th>
                                @foreach($daftarIuranLain as $iuran)
                                    <th class="p-2.5 bg-amber-50 text-amber-900 border-l border-amber-200 text-center uppercase">{{ $iuran->nama_iuran }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @foreach($santriNonMukim as $index => $s)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="p-2 border-r border-slate-200 text-center font-medium">{{ $index + 1 }}</td>
                                    <td class="p-2 border-r border-slate-200 font-bold text-slate-800 uppercase">{{ $s->nama_santri }}</td>
                                    @foreach($urutanBulan as $blnNum => $blnNama)
                                        @php
                                            $lunas = isset($pembayaran[$s->id]) && $pembayaran[$s->id]->where('bulan', $blnNum)->first();
                                        @endphp
                                        <td class="p-2 border-r border-slate-200 text-center">
                                            @if($lunas)
                                                <span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-black rounded text-[9px]">LUNAS</span>
                                            @else
                                                <span class="text-slate-300 font-bold">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="p-2 border-slate-200 text-center font-bold">Rp {{ number_format($s->pilihan_biaya, 0, ',', '.') }}</td>
                                    @foreach($daftarIuranLain as $iuran)
                                        <td class="p-2 border-slate-200 text-center">
                                            @php
                                                $bayarLain = $pembayaranIuranLain->get($s->id)?->firstWhere('iuran_lain_id', $iuran->id);
                                            @endphp
                                            @if($bayarLain && $bayarLain->status_pembayaran == 'Lunas')
                                                <span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-black rounded text-[9px]">LUNAS</span>
                                            @else
                                                <span class="text-slate-300 font-bold">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>