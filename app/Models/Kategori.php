<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = ['nama_kategori', 'tipe_kategori'];

    public function keuangans(): HasMany
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }
}