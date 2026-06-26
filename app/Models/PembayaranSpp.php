<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSpp extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_spp';

    protected $fillable = [
        'santri_id',
        'bulan',
        'tahun',
        'nominal_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_bayar',
        'nama_bendahara'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}