<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';
    
    protected $fillable = ['santri_id', 'user_id', 'tanggal_pelanggaran', 'kategori_pelanggaran', 'deskripsi_pelanggaran'];

    // Relasi: Pelanggaran ini dilakukan oleh santri tertentu
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    // Relasi: Pelanggaran ini dicatat oleh staf (User) tertentu
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}