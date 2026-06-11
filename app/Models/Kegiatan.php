<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = [
        'judul_kegiatan', 'slug', 'deskripsi_singkat', 
        'konten_lengkap', 'foto_kegiatan', 'tanggal_kegiatan', 'penulis'
    ];
}