<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rincian_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('nama_komponen'); // Contoh: Uang Gedung, Seragam, dll.
            $table->enum('jenis_santri', ['mukim', 'non-mukim', 'semua']); // Peruntukan biaya
            $table->integer('nominal'); // Nilai angka bersih (Contoh: 400000)
            $table->timestamps();
        });

        // Mengisi data awal (Seeder default) berdasarkan lampiran brosur kamu
        DB::table('rincian_biaya')->insert([
            ['nama_komponen' => 'Pendaftaran & Observasi', 'jenis_santri' => 'semua', 'nominal' => 150000, 'created_at' => now()],
            ['nama_komponen' => 'Khutbah Arsy & Map', 'jenis_santri' => 'semua', 'nominal' => 100000, 'created_at' => now()],
            ['nama_komponen' => 'Kalender & Kartu Mahram', 'jenis_santri' => 'semua', 'nominal' => 50000, 'created_at' => now()],
            ['nama_komponen' => 'Uang Pangkal & Sewa Lemari', 'jenis_santri' => 'mukim', 'nominal' => 800000, 'created_at' => now()],
            ['nama_komponen' => 'Kasur', 'jenis_santri' => 'mukim', 'nominal' => 350000, 'created_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('rincian_biaya');
    }
};
