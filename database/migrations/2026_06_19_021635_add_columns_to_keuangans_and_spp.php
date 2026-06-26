<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keuangans', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('jenis_transaksi')->constrained('kategoris')->onDelete('set null');
            $table->enum('metode_pembayaran', ['cash', 'rekening'])->default('cash')->after('nominal');
        });

        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['cash', 'rekening'])->default('cash')->after('nominal_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('keuangans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn(['kategori_id', 'metode_pembayaran']);
        });

        Schema::table('pembayaran_spp', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};