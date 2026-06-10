<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            // Menghubungkan santri ke tabel kelas. Jika kelas dihapus, kolom ini set null (kosong).
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            
            // Data Pribadi Santri
            $table->string('nama_santri');
            $table->date('tanggal_lahir');
            $table->text('alamat_santri');
            $table->year('tahun_masuk');
            $table->enum('jenis_santri', ['mukim', 'non-mukim']);
            
            // Status Santri (Default 'pending' saat baru mengisi formulir pendaftaran)
            $table->enum('status_santri', ['pending', 'aktif', 'alumni', 'keluar'])->default('pending');
            
            // Data Pribadi Orang Tua / Wali
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->text('alamat_orang_tua');
            $table->string('no_hp_wali');
            
            // Data Administrasi Pendaftaran (Sesuai Berkas Fisik)
            $table->integer('pilihan_biaya'); // Menampung nominal: 300000, 400000, 500000
            $table->string('file_kk')->nullable(); // Menyimpan path file scan KK
            $table->string('file_akte')->nullable(); // Menyimpan path file scan Akte Kelahiran
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
