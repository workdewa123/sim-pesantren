<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->id();
            // Menghubungkan langsung ke tabel santri. Jika data santri terhapus, histori iurannya ikut terhapus.
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            
            $table->integer('bulan'); // Menyimpan angka bulan (1 s/d 12)
            $table->integer('tahun'); // Menyimpan tahun (contoh: 2026)
            $table->decimal('nominal_bayar', 10, 2); // Nominal SPP wajib per bulan
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable(); // Terisi otomatis saat status diubah ke Lunas
            $table->string('nama_bendahara')->nullable();
            $table->timestamps();
            
            // Mencegah duplikasi: 1 santri tidak boleh punya double record untuk bulan dan tahun yang sama
            $table->unique(['santri_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_spp');
    }
};