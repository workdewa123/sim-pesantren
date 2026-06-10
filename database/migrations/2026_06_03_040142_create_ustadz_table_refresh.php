<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama jika ada agar tidak bentrok
        Schema::dropIfExists('ustadz');

        // Buat tabel ustadz baru dengan kolom yang sesuai kebutuhan kode kita
        Schema::create('ustadz', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ustadz');
            $table->string('spesialisasi');
            $table->string('no_hp');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ustadz');
    }
};