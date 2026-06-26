<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masyayikh', function (Blueprint $table) {
            $table->id();
            $table->string('nama_masyayikh');
            $table->string('slug')->unique();
            $table->string('gelar')->nullable(); // Misal: KH., Lc., M.Ag
            $table->string('foto_masyayikh')->nullable();
            $table->text('biografi_lengkap');
            $table->string('jabatan_pesantren')->nullable(); // Misal: Pengasuh, Dewan Penasehat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masyayikh');
    }
};