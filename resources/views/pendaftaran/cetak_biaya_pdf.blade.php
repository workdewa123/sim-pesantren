<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rincian Biaya Pendaftaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; font-size: 11px; color: #666; }
        .table { w-full; width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { bg-color: #f9f9f9; background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #e8f5e9; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Pondok Pesantren Riyadhul Syamil</h2>
        <p>Bukti Tanda Terima Dokumen & Estimasi Rincian Biaya Awal Santri Baru</p>
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%;">
                <strong>Data Calon Santri:</strong><br>
                Nama: {{ $santri->nama_santri }}<br>
                Jenis Tipe: Santri {{ ucfirst($santri->jenis_santri) }}<br>
                Waktu Daftar: {{ \Carbon\Carbon::parse($santri->created_at)->translatedFormat('d F Y, H:i') }} WIB
            </td>
        </tr>
    </table>

    <h3>Komponen Rincian Biaya Masuk:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Komponen Pengeluaran</th>
                <th class="text-right">Nominal Tarif</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rincianBiaya as $item)
            <tr>
                <td>{{ $item->nama_komponen }}</td>
                <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="font-style: italic;">Iuran Bulanan Berdasarkan Kesanggupan</td>
                <td class="text-right">Rp {{ number_format($santri->pilihan_biaya, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Akumulasi Biaya Pendaftaran Awal</td>
                <td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <p>Panitia Penerimaan Santri Baru (PPSB)</p>
        <br><br><br>
        <p>( __________________________ )</p>
    </div>

</body>
</html>