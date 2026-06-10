<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    protected $table = 'santri';
    
    protected $fillable = [
        'kelas_id', 'nama_santri', 'tanggal_lahir', 'alamat_santri', 
        'tahun_masuk', 'jenis_santri', 'status_santri', 
        'nama_ayah', 'nama_ibu', 'alamat_orang_tua', 'no_hp_wali',
        'pilihan_biaya', 'file_kk', 'file_akte'
    ];

    // Relasi: Santri termasuk dalam sebuah kelas
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi: Satu santri bisa memiliki banyak catatan pelanggaran
    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'santri_id');
    }
}