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
        Schema::create('pengaturan_biaya', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_santri', ['mukim', 'non-mukim']);
            $table->integer('opsi_ke'); // Opsi 1, 2, atau 3
            $table->integer('nominal');  // Menyimpan nominal angka bersih (misal: 300000)
            $table->string('teks_tampilan'); // Menyimpan label (misal: "Rp 300.000")
            $table->timestamps();
        });

        // Masukkan data awal (Seeder bawaan) agar tabel langsung terisi default tarif lama
        DB::table('pengaturan_biaya')->insert([
            ['jenis_santri' => 'mukim', 'opsi_ke' => 1, 'nominal' => 300000, 'teks_tampilan' => 'Rp 300.000', 'created_at' => now()],
            ['jenis_santri' => 'mukim', 'opsi_ke' => 2, 'nominal' => 400000, 'teks_tampilan' => 'Rp 400.000', 'created_at' => now()],
            ['jenis_santri' => 'mukim', 'opsi_ke' => 3, 'nominal' => 500000, 'teks_tampilan' => 'Rp 500.000', 'created_at' => now()],
            ['jenis_santri' => 'non-mukim', 'opsi_ke' => 1, 'nominal' => 30000, 'teks_tampilan' => 'Rp 30.000', 'created_at' => now()],
            ['jenis_santri' => 'non-mukim', 'opsi_ke' => 2, 'nominal' => 40000, 'teks_tampilan' => 'Rp 40.000', 'created_at' => now()],
            ['jenis_santri' => 'non-mukim', 'opsi_ke' => 3, 'nominal' => 50000, 'teks_tampilan' => 'Rp 50.000', 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_biaya');
    }
};
