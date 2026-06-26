<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\UstadzController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Media\MediaController;


// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🌐 1. RUTE PUBLIK: Landing Page Utama (Bisa diakses siapa saja)
Route::get('/home', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/home/kegiatan/{slug}', [LandingPageController::class, 'detailKegiatan'])->name('landing.kegiatan.detail');
Route::get('/home/masyayikh/{slug}', [LandingPageController::class, 'detailMasyayikh'])->name('landing.masyayikh.detail');


// 👥 2. RUTE DASHBOARD: Khusus Staf Media & Admin Utama (Terproteksi Spatie)
Route::middleware(['auth', 'role:staf_media'])->prefix('dashboard-media')->group(function () {
    
    // Halaman Utama Dashboard Media
    Route::get('/', [MediaController::class, 'index'])->name('media.dashboard');
    
    // CRUD Profil Pesantren
    Route::get('/profil', [MediaController::class, 'editProfil'])->name('media.profil.edit');
    Route::put('/profil/update', [MediaController::class, 'updateProfil'])->name('media.profil.update');
    
    // CRUD Berita / Kegiatan Pesantren berbasis AJAX Modal
    Route::get('/kegiatan', [MediaController::class, 'indexKegiatan'])->name('media.kegiatan.index');
    Route::post('/kegiatan/store', [MediaController::class, 'storeKegiatan'])->name('media.kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [MediaController::class, 'editKegiatan']);
    Route::post('/kegiatan/{id}/update', [MediaController::class, 'updateKegiatan'])->name('media.kegiatan.update');
    Route::delete('/kegiatan/{id}/delete', [MediaController::class, 'destroyKegiatan'])->name('media.kegiatan.destroy');

    // Tempelkan di dalam Route::middleware(['auth', 'role:staf_media'])->prefix('dashboard-media')->group(function () { ... })

// CRUD Masyayikh Pesantren
    Route::get('/masyayikh', [App\Http\Controllers\Media\MasyayikhController::class, 'index'])->name('media.masyayikh.index');
    Route::post('/masyayikh/simpan', [App\Http\Controllers\Media\MasyayikhController::class, 'store'])->name('media.masyayikh.store');
    Route::get('/masyayikh/{id}/edit', [App\Http\Controllers\Media\MasyayikhController::class, 'edit'])->name('media.masyayikh.edit');
    Route::post('/masyayikh/update/{id}', [App\Http\Controllers\Media\MasyayikhController::class, 'update'])->name('media.masyayikh.update');
    Route::delete('/masyayikh/hapus/{id}', [App\Http\Controllers\Media\MasyayikhController::class, 'destroy'])->name('media.masyayikh.destroy');
});

Route::get('/', function () {
    return redirect()->route('landing.index');
});

// Kelompok Rute Khusus Admin (Butuh Login)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/pendaftaran-link', [PendaftaranController::class, 'index'])->name('admin.pendaftaran.link');
    Route::post('/pendaftaran-link/refresh', [PendaftaranController::class, 'refreshToken'])->name('admin.pendaftaran.refresh');

    // Tambahkan ini di dalam grup route admin pada web.php
    Route::get('/pengaturan-biaya', [App\Http\Controllers\Admin\PendaftaranController::class, 'indexBiaya'])->name('admin.biaya.index');
    Route::post('/pengaturan-biaya/update', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateBiaya'])->name('admin.biaya.update');

    // CRUD Rincian Biaya Awal Pendaftaran (Uang Gedung, Seragam, dll)
    Route::get('/rincian-biaya', [App\Http\Controllers\Admin\PendaftaranController::class, 'indexRincianBiaya'])->name('admin.rincian.index');
    Route::post('/rincian-biaya/simpan', [App\Http\Controllers\Admin\PendaftaranController::class, 'storeRincianBiaya'])->name('admin.rincian.store');
    Route::post('/rincian-biaya/update/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'updateRincianBiaya'])->name('admin.rincian.update');
    Route::delete('/rincian-biaya/hapus/{id}', [App\Http\Controllers\Admin\PendaftaranController::class, 'destroyRincianBiaya'])->name('admin.rincian.destroy');

    // TAMBAHKAN TIGA BARIS RUTE APPROVAL INI:
    Route::get('/persetujuan', [AdminController::class, 'persetujuanPendaftaran'])->name('admin.persetujuan.index');
    Route::get('/persetujuan/detail/{id}', [AdminController::class, 'detailPersetujuan'])->name('admin.persetujuan.detail');
    Route::post('/persetujuan/setuju/{id}', [AdminController::class, 'prosesSetuju'])->name('admin.persetujuan.setuju');

    // TAMBAHKAN BARIS RUTE CRUD USTADZ INI:
    Route::get('/ustadz', [UstadzController::class, 'index'])->name('admin.ustadz.index');
    Route::get('/ustadz/tambah', [UstadzController::class, 'create'])->name('admin.ustadz.create');
    Route::post('/ustadz/simpan', [UstadzController::class, 'store'])->name('admin.ustadz.store');
    Route::get('/ustadz/edit/{id}', [UstadzController::class, 'edit'])->name('admin.ustadz.edit');
    Route::post('/ustadz/update/{id}', [UstadzController::class, 'update'])->name('admin.ustadz.update');
    Route::delete('/ustadz/hapus/{id}', [UstadzController::class, 'destroy'])->name('admin.ustadz.destroy');

    // TAMBAHKAN BARIS RUTE CRUD KELAS INI:
    Route::get('/kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::get('/kelas/tambah', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('/kelas/simpan', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
    Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/kelas/hapus/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
    Route::post('/kelas/cetak-absensi', [App\Http\Controllers\Admin\KelasController::class, 'cetakAbsensi'])->name('admin.kelas.cetakAbsensi');
    // 🏫 Manajemen Ruang Kelas & Kenaikan Kelas Massal
    Route::get('/kelas/kenaikan', [KelasController::class, 'kenaikanKelasForm'])->name('admin.kelas.kenaikan');
    Route::post('/kelas/kenaikan/proses', [KelasController::class, 'prosesKenaikanKelas'])->name('admin.kelas.prosesKenaikan');

    // TAMBAHKAN BARIS RUTE MANAJEMEN DATA SANTRI INI:
    Route::get('/santri', [SantriController::class, 'index'])->name('admin.santri.index');
    Route::get('/santri/detail/{id}', [SantriController::class, 'show'])->name('admin.santri.show');
    Route::get('/santri/edit/{id}', [SantriController::class, 'edit'])->name('admin.santri.edit');
    Route::post('/santri/update/{id}', [SantriController::class, 'update'])->name('admin.santri.update');
    Route::delete('/santri/hapus/{id}', [SantriController::class, 'destroy'])->name('admin.santri.destroy');

    // 👥 Modul: Manajemen Akun Pengguna / User
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/detail', [App\Http\Controllers\Admin\UserController::class, 'show']); // Untuk Ajax Detail
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit']);     // Untuk Ajax Edit
    Route::put('/users/{id}/update', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}/delete', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

});

// 2. KELOMPOK RUTE BARU: Bisa diakses oleh Admin MAUPUN Pengawas
// PERBAIKAN
Route::middleware(['auth', 'role:pengawas|pencatat'])->prefix('admin')->group(function () {
    // 1. Rute untuk halaman statistik/dashboard info
    Route::get('/pelanggaran/dashboard', [PelanggaranController::class, 'dashboard'])->name('admin.pelanggaran.dashboard');
    
    // 2. Rute untuk halaman utama tabel data (Inilah yang dicari oleh layout Anda)
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('admin.pelanggaran.index');
    // 3. Rute untuk menampilkan detail riwayat pelanggaran santri tertentu
    Route::get('/pelanggaran/detail-santri/{santri_id}', [PelanggaranController::class, 'getDetailSantri']);
    Route::get('/pelanggaran/tambah', [PelanggaranController::class, 'create'])->name('admin.pelanggaran.create');
    Route::post('/pelanggaran/simpan', [PelanggaranController::class, 'store'])->name('admin.pelanggaran.store');
    Route::delete('/pelanggaran/hapus/{id}', [PelanggaranController::class, 'destroy'])->name('admin.pelanggaran.destroy');

    // Cari baris ini di dalam grup middleware staf_pencatat_pelanggaran:
    Route::get('/get-santri/{kelas_id}', [PelanggaranController::class, 'getSantriByKelas'])->name('admin.pelanggaran.get_santri');
});

// Rute Publik untuk Wali Santri (Ganti rute closure lama dengan ini)
Route::get('/register-santri/{token}', [PendaftaranController::class, 'showForm'])->name('pendaftaran.form');
Route::post('/register-santri/{token}', [PendaftaranController::class, 'storeForm'])->name('pendaftaran.store');

// Rute Publik Pasca-Pendaftaran
Route::get('/pendaftaran-sukses/{id}', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
Route::get('/pendaftaran-cetak/{id}', [PendaftaranController::class, 'cetakPdf'])->name('pendaftaran.cetak');
// Tambahkan ini di dekat rute pendaftaran sukses publik pada web.php
Route::get('/pendaftaran/sukses/{id}/cetak-biaya', [App\Http\Controllers\Admin\PendaftaranController::class, 'cetakBiayaPdf'])->name('pendaftaran.cetak_biaya');

// =========================================================================
// 🔒 KELOMPOK RUTE KHUSUS BENDAHARA (MANAJEMEN KEUANGAN & LAPORAN)
// =========================================================================
Route::middleware(['auth', 'role:bendahara'])->prefix('admin/keuangan')->group(function () {
    
    // 📊 Dasbor Utama Keuangan (Grafik Kas & Ringkasan Total Saldo)
    // =========================================================================
    // 💰 MODUL MANAJEMEN KEUANGAN UTAMA (ADMIN)
    // =========================================================================
    Route::get('/dashboard', [App\Http\Controllers\Admin\KeuanganController::class, 'dashboard'])->name('admin.keuangan.dashboard');
    
    // 💵 Sub-Modul 1: Buku Kas Umum (Pemasukan & Pengeluaran Operasional)
    Route::get('/kas-umum', [App\Http\Controllers\Admin\KeuanganController::class, 'indexKas'])->name('admin.keuangan.kas.index');
    Route::post('/kas-umum/simpan', [App\Http\Controllers\Admin\KeuanganController::class, 'storeKas'])->name('admin.keuangan.kas.store');
    Route::put('/kas-umum/update/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'updateKas'])->name('admin.keuangan.kas.update'); // 🌟 TAMBAHAN UNTUK EDIT MODAL
    Route::delete('/kas-umum/hapus/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'destroyKas'])->name('admin.keuangan.kas.destroy');

    // 🧑‍🎓 Sub-Modul 2: Pembayaran SPP Bulanan Santri
    Route::get('/spp', [App\Http\Controllers\Admin\KeuanganController::class, 'indexSpp'])->name('admin.keuangan.spp.index');
    Route::post('/spp/store-pembayaran', [App\Http\Controllers\Admin\KeuanganController::class, 'storePembayaranSpp'])->name('admin.keuangan.spp.store');
    Route::post('/spp/bayar/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'prosesBayarSpp'])->name('admin.keuangan.spp.bayar');
    Route::put('/spp/update/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'updateSpp'])->name('admin.keuangan.spp.update'); // 🌟 TAMBAHAN UNTUK EDIT MODAL
    Route::post('/spp/generate-tagihan', [App\Http\Controllers\Admin\KeuanganController::class, 'generateTagihanBulanan'])->name('admin.keuangan.spp.generate');
    Route::get('/spp/get-santri-by-kelas/{kelas_id}', [App\Http\Controllers\Admin\KeuanganController::class, 'getSantriByKelas'])->name('admin.keuangan.spp.get_santri');

    // 🏷️ Sub-Modul Tambahan: Pengelola Kategori Transaksi Buku Kas
    Route::get('/kategori', [App\Http\Controllers\Admin\KeuanganController::class, 'indexKategori'])->name('admin.keuangan.kategori.index');
    Route::post('/kategori/simpan', [App\Http\Controllers\Admin\KeuanganController::class, 'storeKategori'])->name('admin.keuangan.kategori.store');
    Route::put('/kategori/update/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'updateKategori'])->name('admin.keuangan.kategori.update'); // 🌟 TAMBAHAN UNTUK EDIT MODAL
    Route::delete('/kategori/hapus/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'destroyKategori'])->name('admin.keuangan.kategori.destroy');

    // 🖨️ Sub-Modul 3: Unduh Laporan Resmi Keuangan
    Route::post('/laporan/cetak', [App\Http\Controllers\Admin\KeuanganController::class, 'cetakLaporan'])->name('admin.keuangan.laporan.cetak');
    Route::post('/laporan/excel', [App\Http\Controllers\Admin\KeuanganController::class, 'exportExcel'])->name('admin.keuangan.laporan.excel');

    // Pastikan baris-baris ini ada di dalam prefix('/keuangan') Anda:
    Route::put('/spp/update/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'updateSpp'])->name('admin.keuangan.spp.update');
    Route::delete('/spp/hapus/{id}', [App\Http\Controllers\Admin\KeuanganController::class, 'destroySpp'])->name('admin.keuangan.spp.destroy');
    // Tambahkan ini di dalam group middleware bendahara pada web.php
    Route::post('/spp/laporan-matriks', [App\Http\Controllers\Admin\KeuanganController::class, 'exportMatriksExcel'])->name('admin.keuangan.spp.laporan_matriks');
    // Tambahkan route ini di web.php (di dalam grup bendahara)
    Route::post('/spp/laporan-matriks/preview', [App\Http\Controllers\Admin\KeuanganController::class, 'previewMatriksHtml'])->name('admin.keuangan.spp.laporan_matriks.preview');

    // =========================================================================
    // 🏦 SUB-MODUL BARU: MANAJEMEN IURAN LAIN-LAIN (NON-SPP)
    // =========================================================================
    Route::get('/iuran-lain', [App\Http\Controllers\Admin\IuranLainController::class, 'index'])->name('admin.keuangan.iuran_lain.index');
    Route::post('/iuran-lain/store', [App\Http\Controllers\Admin\IuranLainController::class, 'store'])->name('admin.keuangan.iuran_lain.store');
    Route::put('/iuran-lain/update/{id}', [App\Http\Controllers\Admin\IuranLainController::class, 'update'])->name('admin.keuangan.iuran_lain.update');
    Route::delete('/iuran-lain/hapus/{id}', [App\Http\Controllers\Admin\IuranLainController::class, 'destroy'])->name('admin.keuangan.iuran_lain.destroy');
    
    // Rute Tambahan untuk Transaksi Loket Pembayaran Iuran Lain
    Route::post('/iuran-lain/bayar', [App\Http\Controllers\Admin\IuranLainController::class, 'storePembayaran'])->name('admin.keuangan.iuran_lain.bayar');

    });