<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ustadz extends Model
{
    protected $table = 'ustadz';
    protected $fillable = ['nama_ustadz', 'telepon', 'alamat'];
}