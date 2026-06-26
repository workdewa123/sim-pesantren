<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel Master Master Program Iuran
        Schema::create('iuran_lain', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iuran'); // Contoh: "KITAB PAK GUS TAQIN", "RENOVASI MUSHOLLA"
            $table->integer('tahun_hijriyah'); // Terikat dengan tahun rekap rekapitulasi, misal: 1447
            $table->timestamps();
        });

        // 2. Tabel Transaksi Pembayaran Iuran Per Santri
        Schema::create('pembayaran_iuran_lain', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('iuran_lain_id')->constrained('iuran_lain')->onDelete('cascade');
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas'])->default('Lunas'); // Biasanya iuran kondisional langsung lunas sekali bayar
            $table->date('tanggal_bayar')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->timestamps();

            // Mencegah satu santri membayar iuran program yang sama dua kali
            $table->unique(['santri_id', 'iuran_lain_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_iuran_lain');
        Schema::dropIfExists('iuran_lain');
    }
};