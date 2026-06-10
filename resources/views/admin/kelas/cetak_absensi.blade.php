<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Absensi Santri</title>
    <style>
        @page {
            margin: 12mm 10mm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px double #222;
            padding-bottom: 5px;
        }
        .header h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
            color: #111;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 9pt;
            color: #555;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 9.5pt;
        }
        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .table-absensi {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        .table-absensi th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            border: 1px solid #444;
            padding: 5px 2px;
            text-align: center;
        }
        .table-absensi td {
            border: 1px solid #444;
            padding: 5px 4px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .kolom-tanggal {
            width: 18px;
            max-width: 18px;
        }
        .kolom-rekap {
            width: 22px;
            background-color: #fafafa;
            font-weight: bold;
        }
        .ttd-section {
            width: 100%;
            margin-top: 25px;
            font-size: 9.5pt;
        }
        .ttd-section td {
            width: 50%;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Formulir Presensi & Absensi Santri</h2>
        <p>PPRA AL-GHOZALI — Dokumen Administrasi Pembelajaran Kelas</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 10%;"><strong>Kelas</strong></td>
            <td style="width: 40%;">: {{ $kelas->nama_kelas }}</td>
            <td style="width: 12%;"><strong>Bulan / Tahun</strong></td>
            <td style="width: 38%;">: {{ $namaBulan }} / {{ $tahun }}</td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>: {{ $kelas->nama_ustadz ?? 'Belum ditentukan' }}</td>
            <td><strong>Kertas Dokumen</strong></td>
            <td>: A4 Standar (Kosongan Manual)</td>
        </tr>
    </table>

    <table class="table-absensi">
        <thead>
            <tr>
                <th rowspan="3" style="width: 3%;">No</th>
                <th rowspan="3" style="width: 22%; text-align: left; padding-left: 8px;">Nama Lengkap Santri</th>
                <th colspan="{{ $jumlahHari }}">Tanggal Bulan {{ $namaBulan }}</th>
                <th colspan="3">Rekap</th>
            </tr>
            {{-- Baris Pertama: Angka Tanggal (1 - 31) --}}
            <tr>
                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th class="kolom-tanggal">{{ $i }}</th>
                @endfor
                <th rowspan="2" class="kolom-rekap">S</th>
                <th rowspan="2" class="kolom-rekap">I</th>
                <th rowspan="2" class="kolom-rekap">A</th>
            </tr>
            {{-- Baris Kedua 🌟 BARU: Inisial Huruf Depan Nama Hari (S, S, R, K, J, S, M) --}}
            <tr>
                @for ($i = 1; $i <= $jumlahHari; $i++)
                    @php
                        // Menghitung urutan hari (1 untuk Senin, 7 untuk Minggu)
                        $timestamp = mktime(0, 0, 0, $kelas->bulan ?? request('bulan'), $i, $tahun);
                        $angkaHari = date('N', $timestamp);
                        
                        // Mapping angka hari ke inisial huruf depan bahasa Indonesia
                        $inisialHari = [
                            1 => 'S', // Senin
                            2 => 'S', // Selasa
                            3 => 'R', // Rabu
                            4 => 'K', // Kamis
                            5 => 'J', // Jumat
                            6 => 'S', // Sabtu
                            7 => 'M'  // Minggu
                        ][$angkaHari];

                        // Opsional: Berikan warna latar abu-abu agak gelap jika hari Minggu agar ustadz tahu itu hari libur
                        $bgMinggu = ($angkaHari == 7) ? 'background-color: #e2e8f0;' : '';
                    @endphp
                    <th class="kolom-tanggal" style="font-size: 7.5pt; font-weight: normal; border-top: 1px solid #ccc; {{ $bgMinggu }}">
                        {{ $inisialHari }}
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarSantri as $index => $santri)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $santri->nama_santri }}</td>
                    
                    {{-- Kotak kosong untuk presensi manual --}}
                    @for ($i = 1; $i <= $jumlahHari; $i++)
                        @php
                            // Samakan deteksi hari minggu untuk baris data santri agar terlihat selaras
                            $timestampCell = mktime(0, 0, 0, $kelas->bulan ?? request('bulan'), $i, $tahun);
                            $bgCellMinggu = (date('N', $timestampCell) == 7) ? 'background-color: #f1f5f9;' : '';
                        @endphp
                        <td style="{{ $bgCellMinggu }}"></td>
                    @endfor
                    
                    <td class="kolom-rekap"></td>
                    <td class="kolom-rekap"></td>
                    <td class="kolom-rekap"></td>
                </tr>
            @empty
                <tr>
                    {{-- Ditambah 5 kolom karena kolom nomor, nama, S, I, A --}}
                    <td colspan="{{ $jumlahHari + 5 }}" class="text-center" style="padding: 20px; font-style: italic; color: #777;">
                        Belum ada data santri aktif terplot di kelas ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="ttd-section">
        <tr>
            <td></td>
            <td class="text-center">
                ..................., ............................ {{ $tahun }}<br>
                Wali Kelas {{ $kelas->nama_kelas }},
                <br><br><br><br><br>
                <strong><u>{{ $kelas->nama_ustadz ?? '(..........................................)' }}</u></strong>
            </td>
        </tr>
    </table>

</body>
</html>