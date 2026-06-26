<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; width: 100%; font-family: sans-serif; font-size: 11px; }
        th { background-color: #065f46; color: white; border: 1px solid #cbd5e1; padding: 6px; text-align: center; font-weight: bold; }
        td { border: 1px solid #cbd5e1; padding: 5px; vertical-align: middle; }
        .title { font-size: 14px; font-weight: bold; text-align: center; }
        .section-header { background-color: #f1f5f9; font-weight: bold; font-size: 12px; padding: 8px 5px; color: #1e293b; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .lunas { color: #047857; font-weight: 500; font-size: 10px; }
        .belum { color: #64748b; font-style: italic; font-size: 10px; }
    </style>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th colspan="15" class="title" style="background-color: white; color: black; border: none; padding-bottom: 10px;">
                    SPP SANTRI MUKIM TAHUN {{ $tahun }} H
                </th>
            </tr>
            <tr>
                <th width="40">NO</th>
                <th width="200" class="bg-succes">NAMA SANTRI</th>
                @foreach($urutanBulan as $code => $namaBulan)
                    <th width="100">{{ $namaBulan }}</th>
                @endforeach
                <th width="110">NOMINAL WAJIB</th>
                @foreach($daftarIuranLain as $iuran)
                    <th class="p-2.5 bg-amber-50 text-amber-900 border-l border-amber-200 text-center uppercase">{{ $iuran->nama_iuran }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($santriMukim as $index => $santri)
                @php
                    $riwayat = $pembayaran->get($santri->id) ?? collect();
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ strtoupper($santri->nama_santri) }}</td>
                    
                    @foreach($urutanBulan as $bulanAngka => $namaBulan)
                        @php
                            $bayar = $riwayat->firstWhere('bulan', $bulanAngka);
                        @endphp
                        <td class="text-center">
                            @if($bayar && $bayar->status_pembayaran == 'Lunas')
                                <span class="lunas">{{ $bayar->tanggal_bayar ? date('Y-m-d', strtotime($bayar->tanggal_bayar)) : 'LUNAS' }}</span>
                            @else
                                <span class="belum">-</span>
                            @endif
                        </td>
                    @endforeach
                    
                    <td class="text-right" style="font-weight: bold;">RP. {{ number_format($santri->pilihan_biaya, 0, ',', '.') }}</td>
                    @foreach($daftarIuranLain as $iuran)
                        @php
                            $bayarLain = $pembayaranIuranLain->get($santri->id)?->firstWhere('iuran_lain_id', $iuran->id);
                        @endphp
                        <td class="text-center">
                            @if($bayarLain && $bayarLain->status_pembayaran == 'Lunas')
                                <span class="lunas">{{ $bayarLain->tanggal_bayar ? date('Y-m-d', strtotime($bayarLain->tanggal_bayar)) : 'LUNAS' }}</span>
                            @else
                                <span class="belum">-</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table>
        <thead>
            <tr>
                <th colspan="15" class="title" style="background-color: white; color: black; border: none; padding-bottom: 10px;">
                    SPP SANTRI NON MUKIM TAHUN {{ $tahun }} H
                </th>
            </tr>
            <tr>
                <th width="40">NO</th>
                <th width="200">NAMA SANTRI</th>
                @foreach($urutanBulan as $code => $namaBulan)
                    <th width="100">{{ $namaBulan }}</th>
                @endforeach
                <th width="110">NOMINAL WAJIB</th>
                @foreach($daftarIuranLain as $iuran)
                    <th class="p-2.5 bg-amber-50 text-amber-900 border-l border-amber-200 text-center uppercase">{{ $iuran->nama_iuran }}</th>  
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($santriNonMukim as $index => $santri)
                @php
                    $riwayat = $pembayaran->get($santri->id) ?? collect();
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ strtoupper($santri->nama_santri) }}</td>
                    
                    @foreach($urutanBulan as $bulanAngka => $namaBulan)
                        @php
                            $bayar = $riwayat->firstWhere('bulan', $bulanAngka);
                        @endphp
                        <td class="text-center">
                            @if($bayar && $bayar->status_pembayaran == 'Lunas')
                                <span class="lunas">{{ $bayar->tanggal_bayar ? date('Y-m-d', strtotime($bayar->tanggal_bayar)) : 'LUNAS' }}</span>
                            @else
                                <span class="belum">-</span>
                            @endif
                        </td>
                    @endforeach
                    
                    <td class="text-right" style="font-weight: bold;">RP. {{ number_format($santri->pilihan_biaya, 0, ',', '.') }}</td>
                    @foreach($daftarIuranLain as $iuran)
                        @php
                            $bayarLain = $pembayaranIuranLain->get($santri->id)?->firstWhere('iuran_lain_id', $iuran->id);
                        @endphp
                        <td class="text-center">
                            @if($bayarLain && $bayarLain->status_pembayaran == 'Lunas')
                                <span class="lunas">{{ $bayarLain->tanggal_bayar ? date('Y-m-d', strtotime($bayarLain->tanggal_bayar)) : 'LUNAS' }}</span>
                            @else
                                <span class="belum">-</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>