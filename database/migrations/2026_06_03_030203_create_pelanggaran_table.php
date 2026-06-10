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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel santri. Jika santri dihapus, data pelanggarannya juga terhapus.
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            
            // Menghubungkan ke tabel users (staf pencatat yang sedang login)
            $table->foreignId('user_id')->constrained('users');
            
            $table->date('tanggal_pelanggaran');
            $table->string('kategori_pelanggaran'); // Contoh: Ringan, Sedang, Berat
            $table->text('deskripsi_pelanggaran');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
