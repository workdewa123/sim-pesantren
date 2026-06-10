<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->string('kategori'); // Contoh: 'SPP Santri', 'Donasi', 'Listrik', 'Beli Beras'
            $table->decimal('nominal', 12, 2); // Menampung nominal hingga ratusan miliar rupiah
            $table->text('keterangan')->nullable();
            $table->string('nama_bendahara'); // Mencatat nama bendahara yang bertugas saat itu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};