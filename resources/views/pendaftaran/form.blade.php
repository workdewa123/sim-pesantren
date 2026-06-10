<!DOCTYPE html>
<html lang="id" class="bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Santri Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        
        <div class="bg-gradient-to-r from-emerald-800 to-teal-950 p-6 sm:p-8 text-white text-center flex flex-col items-center justify-center">
            <img src="{{ asset('img/Logo_PPRA.jpg') }}" alt="Logo Ponpes" class="w-16 h-16 object-contain mb-3 rounded-xl bg-white/10 p-1.5 border border-white/20 shadow-lg">
            <h2 class="text-2xl font-bold tracking-tight">Formulir Pendaftaran Santri Baru</h2>
            <p class="text-emerald-200 text-xs sm:text-sm mt-1 max-w-xl">Silakan isi data calon santri dan orang tua dengan lengkap dan benar sesuai dokumen resmi.</p>
        </div>

        <form action="{{ route('pendaftaran.store', ['token' => $token]) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf

            <div>
                <div class="flex items-center border-b border-slate-200 pb-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs mr-3">A</span>
                    <h3 class="text-base font-bold text-slate-800 uppercase tracking-wide">Data Pribadi Calon Santri</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Santri</label>
                        <input type="text" name="nama_santri" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: Muhammad Ali">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Tahun Masuk / Angkatan</label>
                        <input type="number" name="tahun_masuk" value="{{ date('Y') }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Kepesertaan Santri</label>
                        <div class="flex gap-4 mt-1.5">
                            <label class="flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="radio" name="jenis_santri" value="mukim" checked class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-700 mr-2"> Mukim (Tinggal di Asrama)
                            </label>
                            <label class="flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="radio" name="jenis_santri" value="non-mukim" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-700 mr-2"> Non-Mukim (Laju/Pulang Pergi)
                            </label>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Lengkap Santri</label>
                        <textarea name="alamat_santri" rows="2" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Nama jalan, RT/RW, Dusun, Desa, Kecamatan"></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center border-b border-slate-200 pb-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs mr-3">B</span>
                    <h3 class="text-base font-bold text-slate-800 uppercase tracking-wide">Data Pribadi Orang Tua / Wali</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Ayah</label>
                        <input type="text" name="nama_ayah" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Nama ayah kandung">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Ibu</label>
                        <input type="text" name="nama_ibu" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Nama ibu kandung">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Telepon / WhatsApp Wali</label>
                        <input type="text" name="no_hp_wali" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: 081234567xxx">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Orang Tua / Wali</label>
                        <textarea name="alamat_orang_tua" rows="2" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Tulis alamat orang tua jika berbeda dengan alamat santri"></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center border-b border-slate-200 pb-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs mr-3">C</span>
                    <h3 class="text-base font-bold text-slate-800 uppercase tracking-wide">Pernyataan Kesanggupan Biaya</h3>
                </div>
                
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 sm:p-5">
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">Sesuai dengan ketentuan pesantren, saya selaku orang tua/wali menyatakan bersedia membayar Biaya Pendidikan Pondok Pesantren bulanan sebesar pilihan yang saya pilih di bawah ini:</p>
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pernyataan Kesanggupan Biaya Bulanan (SPP)</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all text-center gap-1">
                                <input type="radio" name="kesanggupan_biaya" value="300000" checked class="radio-biaya w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-700">
                                <span class="text-xs font-bold text-slate-700 label-biaya">Rp 300.000</span>
                                <span class="text-[9px] text-slate-400">Pilihan 01</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all text-center gap-1">
                                <input type="radio" name="kesanggupan_biaya" value="400000" class="radio-biaya w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-700">
                                <span class="text-xs font-bold text-slate-700 label-biaya">Rp 400.000</span>
                                <span class="text-[9px] text-slate-400">Pilihan 02</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-all text-center gap-1">
                                <input type="radio" name="kesanggupan_biaya" value="500000" class="radio-biaya w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-700">
                                <span class="text-xs font-bold text-slate-700 label-biaya">Rp 500.000</span>
                                <span class="text-[9px] text-slate-400">Pilihan 03</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center border-b border-slate-200 pb-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs mr-3">D</span>
                    <h3 class="text-base font-bold text-slate-800 uppercase tracking-wide">Unggah Berkas Lampiran</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Scan / Foto Kartu Keluarga (KK)</label>
                        <input type="file" name="file_kk" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-lg p-1.5 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG (Maksimal 2MB)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Scan / Foto Akte Kelahiran</label>
                        <input type="file" name="file_akte" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-lg p-1.5 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG (Maksimal 2MB)</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3.5 px-4 rounded-xl text-sm transition-all duration-150 shadow-md shadow-emerald-800/10 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Formulir Pendaftaran
                </button>
            </div>
        </form>
    </div>

</body>
</html>

<script>
    document.querySelectorAll('input[name="jenis_santri"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const radioBiaya = document.querySelectorAll('.radio-biaya');
            const labelBiaya = document.querySelectorAll('.label-biaya');
            
            // UBAH DI SINI: Gunakan huruf kecil 'non-mukim' agar sinkron dengan value HTML
            if (this.value === 'non-mukim') {
                // Konfigurasi Nominal untuk Non-Mukim (Laju)
                const nominalNonMukim = ['30000', '40000', '50000'];
                const teksNonMukim = ['Rp 30.000', 'Rp 40.000', 'Rp 50.000'];
                
                radioBiaya.forEach((input, index) => {
                    input.value = nominalNonMukim[index];
                    labelBiaya[index].innerText = teksNonMukim[index];
                });
            } else {
                // Kembali ke Konfigurasi Nominal Mukim (Asrama)
                const nominalMukim = ['300000', '400000', '500000'];
                const teksMukim = ['Rp 300.000', 'Rp 400.000', 'Rp 500.000'];
                
                radioBiaya.forEach((input, index) => {
                    input.value = nominalMukim[index];
                    labelBiaya[index].innerText = teksMukim[index];
                });
            }
        });
    });
</script>