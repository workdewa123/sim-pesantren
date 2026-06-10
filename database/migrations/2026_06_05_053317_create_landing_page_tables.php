<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Profil Pesantren (Dinamis isi visi, misi, kontak)
        Schema::create('profil_pesantren', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pesantren');
            $table->string('logo_pesantren')->nullable();
            $table->text('sejarah_singkat');
            $table->text('visi');
            $table->text('misi');
            $table->string('alamat');
            $table->string('whatsapp_kontak');
            $table->string('instagram_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Berita / Kegiatan Pesantren (CRUD Tim Media)
        Schema::create('kegiatan_pesantren', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->string('slug')->unique();
            $table->text('deskripsi_singkat');
            $table->longText('konten_lengkap');
            $table->string('foto_kegiatan')->nullable();
            $table->date('tanggal_kegiatan');
            $table->string('penulis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_pesantren');
        Schema::dropIfExists('profil_pesantren');
    }
};