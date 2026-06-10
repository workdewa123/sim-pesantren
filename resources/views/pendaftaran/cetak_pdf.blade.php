<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $santri->nama_santri }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.4; font-size: 13px; }
        .text-center { text-center: center; }
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; text-align: center; }
        .kop-surat h2 { margin: 0; font-size: 18px; text-transform: uppercase; color: #064e3b; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 11px; color: #555; }
        .judul-form { text-transform: uppercase; font-weight: bold; font-size: 14px; text-align: center; margin-bottom: 25px; text-decoration: underline; }
        .section-title { font-weight: bold; background-color: #f1f5f9; padding: 5px 10px; margin-top: 15px; margin-bottom: 10px; font-size: 12px; border-left: 4px solid #047857; text-transform: uppercase; }
        table { w-full: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table td { padding: 6px 4px; vertical-align: top; }
        table td.label { w-full: 30%; font-weight: 500; color: #4b5563; }
        table td.colon { w-full: 2%; }
        .pernyataan { font-size: 11px; text-align: justify; color: #444; margin-top: 15px; }
        .pernyataan ol { margin-left: 0; padding-left: 15px; }
        .pernyataan li { margin-bottom: 4px; }
        .ttd-container { margin-top: 40px; w-full: 100%; }
        .ttd-box { float: right; w-full: 40%; text-align: center; }
        .ttd-box-left { float: left; w-full: 40%; text-align: center; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Pondok Pesantren Al-Rasyid</h2>
        <p>Jl. Raya Pesantren No. 45, Malang, Jawa Timur | Telp/WA: 081234567xxx</p>
    </div>

    <div class="judul-form">Dokumen Bukti Pendaftaran & Pernyataan Kesanggupan</div>

    <div class="section-title">A. Data Pribadi Santri</div>
    <table>
        <tr>
            <td class="label">Nama Lengkap Santri</td>
            <td class="colon">:</td>
            <td><strong>{{ $santri->nama_santri }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Lahir</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($santri->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $santri->alamat_santri }}</td>
        </tr>
        <tr>
            <td class="label">Tahun Masuk / Angkatan</td>
            <td class="colon">:</td>
            <td>{{ $santri->tahun_masuk }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kepesertaan</td>
            <td class="colon">:</td>
            <td>Santri {{ ucfirst($santri->jenis_santri) }}</td>
        </tr>
    </table>

    <div class="section-title">B. Data Pribadi Orang Tua / Wali Santri</div>
    <table>
        <tr>
            <td class="label">Nama Lengkap Ayah</td>
            <td class="colon">:</td>
            <td>{{ $santri->nama_ayah }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap Ibu</td>
            <td class="colon">:</td>
            <td>{{ $santri->nama_ibu }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Orang Tua / Wali</td>
            <td class="colon">:</td>
            <td>{{ $santri->alamat_orang_tua }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Telepon / WA</td>
            <td class="colon">:</td>
            <td>{{ $santri->no_hp_wali }}</td>
        </tr>
    </table>

    <div class="section-title">C. Pernyataan Kesanggupan</div>
    <div class="pernyataan">
        <p>SAYA SELAKU ORANG TUA/WALI SANTRI DI ATAS MENYATAKAN BERSSEDIA DAN SANGGUP :</p>
        <ol>
            <li>Kami Berniat Mengajikan Putra Kami Karena Alloh SWT.</li>
            <li>Bersedia Mengikuti Pendidikan Dan Mematuhi Segala Peraturan Yang Ditetapkan Pihak Pondok Pesantren.</li>
            <li>Menyerahkan Kepada Pihak Pondok Pesantren Untuk Mengambil Kebijakan Yang Perlu Dalam Proses Belajar Mengajar.</li>
            <li>Bersedia Membayar Biaya Pendidikan Pondok Pesantren Sebesar Pilihan Yang Dipilih: <strong>Rp {{ number_format($santri->pilihan_biaya, 0, ',', '.') }} / Bulan</strong>.</li>
            <li>Bersedia Dikeluarkan Dari Pondok Pesantren Bila Santri Yang Bersangkutan Melanggar Peraturan Dan Disiplin Pondok Pesantren.</li>
        </ol>
        <p>Demikian Pernyataan Kesanggupan Ini Dibuat Dengan Sebenar-Benarnya Tanpa Adanya Tekanan Maupun Paksaan Dari Pihak Manapun.</p>
    </div>

    <div class="ttd-container">
        <div class="ttd-box-left">
            <p>Kepala Pondok Pesantren,</p>
            <br><br><br><br>
            <p><strong>Agus M. Rojib Izil Muttaqin</strong></p>
        </div>
        <div class="ttd-box">
            <p>Malang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Orang Tua / Wali Santri,</p>
            <br><br><br><br>
            <p>__________________________</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>