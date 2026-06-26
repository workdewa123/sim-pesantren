<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IuranLain extends Model
{
    protected $table = 'iuran_lain';
    protected $fillable = ['nama_iuran', 'tahun_hijriyah'];

    public function pembayaran()
    {
        return $this->hasMany(PembayaranIuranLain::class, 'iuran_lain_id');
    }
}