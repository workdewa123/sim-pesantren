<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Amankan data lama: Paksa semua data yang mirip 'aktif' menjadi 'aktif' huruf kecil
        DB::table('santri')
            ->where('status_santri', 'like', 'aktif')
            ->update(['status_santri' => 'aktif']);

        // 2. Jika ada data kosong atau status aneh, set default ke 'aktif' sementara
        DB::table('santri')
            ->whereNotIn('status_santri', ['aktif', 'non-aktif'])
            ->update(['status_santri' => 'aktif']);

        // 3. Jalankan alter table setelah data dipastikan bersih
        DB::statement("ALTER TABLE santri MODIFY COLUMN status_santri ENUM('aktif', 'non-aktif', 'lulus') NOT NULL DEFAULT 'aktif'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE santri MODIFY COLUMN status_santri ENUM('aktif', 'non-aktif') NOT NULL DEFAULT 'aktif'");
    }
};