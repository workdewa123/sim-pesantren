<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';

    protected $fillable = [
        'tanggal_transaksi',
        'jenis_transaksi',
        'kategori_id',
        'kategori',
        'nominal',
        'metode_pembayaran', // 'cash' atau 'rekening'
        'keterangan',
        'nama_bendahara'
    ];

    public function kategoriRelasi(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}