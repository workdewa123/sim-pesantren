<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'keterangan'];

    // Relasi: Satu kelas memiliki banyak santri
    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'kelas_id');
    }
}