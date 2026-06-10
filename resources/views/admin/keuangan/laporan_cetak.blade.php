<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Keuangan_Pesantren_{{ $request->dari_tanggal }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 20px; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; font-size: 11px; color: #666; }
        .meta-info { margin-bottom: 15px; font-weight: bold; }
        
        /* PERBAIKAN PADA TABEL UTAMA */
        table { 
            width: 100%; /* Memperbaiki typo w-full sebelumnya */
            table-layout: fixed; /* Mengunci total lebar kolom agar patuh pada pembagian persen */
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        
        th, td { 
            border: 1px solid #999; 
            padding: 7px 10px; 
            text-align: left;
            vertical-align: top; /* Membuat teks sejajar di atas jika kolom sebelah memanjang ke bawah */
        }
        
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .pemasukan { color: #065f46; font-weight: bold; }
        .pengeluaran { color: #991b1b; font-weight: bold; }
        
        /* ATURAN UNTUK MEMBAGI LEBAR KOLOM SECARA PROPORSIONAL */
        table th:nth-child(1), table td:nth-child(1) { width: 15%; } /* Kolom Tanggal */
        table th:nth-child(2), table td:nth-child(2) { width: 20%; } /* Kolom Kategori */
        
        /* Fokus Perbaikan Kolom Keterangan */
        table th:nth-child(3), table td:nth-child(3) { 
            width: 35%; 
            word-wrap: break-word; /* Memaksa kata yang sangat panjang untuk patah/turun ke bawah */
            overflow-wrap: break-word; 
            white-space: normal; /* Memastikan teks membungkus normal tidak memanjang ke samping */
        } 
        
        table th:nth-child(4), table td:nth-child(4) { width: 15%; } /* Kolom Bendahara */
        table th:nth-child(5), table td:nth-child(5) { width: 15%; } /* Kolom Nominal */

        .summary-box { width: 100%; margin-top: 15px; }
        .summary-box table { width: 45%; float: right; border: none; }
        .summary-box table td { border: none; padding: 4px 0; }
        .clearfix { clear: both; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Pondok Pesantren Riyadlotul Athfal Al-Ghozali</h2>
        <p>Jl. Kyai Ghozali No.138, Tegalpsangan, Pakiskembar, Kec. Pakis, Kabupaten Malang, Jawa Timur 65154</p>
        <p style="font-size: 14px; font-weight: bold; color: #000; margin-top: 10px;">LAPORAN ARUS KAS KEUANGAN</p>
    </div>

    <div class="meta-info">
        <table style="width: 100%; border: none; margin-bottom: 5px;">
            <tr style="border: none;">
                <td style="width: 12%; border: none; padding: 2px 0;">Periode Laporan</td>
                <td style="width: 2%; border: none; padding: 2px 0;">:</td>
                <td style="border: none; padding: 2px 0;">{{ date('d M Y', strtotime($request->dari_tanggal)) }} s/d {{ date('d M Y', strtotime($request->sampai_tanggal)) }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 0;">Filter Kategori</td>
                <td style="border: none; padding: 2px 0;">:</td>
                <td style="border: none; padding: 2px 0;" style="text-transform: capitalize;">{{ $request->kategori ?? 'Semua Kategori' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan / Deskripsi</th>
                <th>Bendahara</th>
                <th class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataLaporan as $row)
            <tr>
                <td class="text-center">{{ date('d-m-Y', strtotime($row->tanggal_transaksi)) }}</td>
                <td><strong>{{ $row->kategori }}</strong></td>
                <td>{{ $row->keterangan ?? '-' }}</td>
                <td>{{ $row->nama_bendahara }}</td>
                <td class="text-right {{ $row->jenis_transaksi == 'pemasukan' ? 'pemasukan' : 'pengeluaran' }}">
                    {{ $row->jenis_transaksi == 'pemasukan' ? '' : '-' }}{{ number_format($row->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <table>
            <tr>
                <td>Total Arus Pemasukan</td>
                <td class="text-right pemasukan">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Arus Pengeluaran</td>
                <td class="text-right pengeluaran">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 1px solid #333; font-weight: bold;">
                <td style="padding-top: 6px;">Saldo Bersih Terbuku</td>
                <td class="text-right" style="padding-top: 6px; color: #000;">Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div class="clearfix"></div>
    </div>

</body>
</html>