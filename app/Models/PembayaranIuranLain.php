<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranIuranLain extends Model
{
    protected $table = 'pembayaran_iuran_lain';
    protected $fillable = ['santri_id', 'iuran_lain_id', 'status_pembayaran', 'tanggal_bayar', 'nama_bendahara'];

    public function iuranLain()
    {
        return $this->belongsTo(IuranLain::class, 'iuran_lain_id');
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}