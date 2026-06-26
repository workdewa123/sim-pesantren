<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masyayikh extends Model
{
    // Mengunci nama tabel agar sesuai dengan migration
    protected $table = 'masyayikh';

    // Kolom-kolom yang diizinkan untuk diisi massal lewat Controller
    protected $fillable = [
        'nama_masyayikh',
        'slug',
        'gelar',
        'foto_masyayikh',
        'biografi_lengkap',
        'jabatan_pesantren'
    ];
}