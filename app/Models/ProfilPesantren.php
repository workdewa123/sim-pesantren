<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilPesantren extends Model
{
    protected $table = 'profil_pesantren';
    protected $fillable = [
        'nama_pesantren', 'logo_pesantren', 'sejarah_singkat', 
        'visi', 'misi', 'alamat', 'whatsapp_kontak', 
        'instagram_link', 'facebook_link', 'youtube_link'
    ];
}