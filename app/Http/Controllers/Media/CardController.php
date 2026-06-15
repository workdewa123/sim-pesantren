<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardController extends Controller
{
    //

    public function index()
    {
        return view('media.kegiatan.index');        
    }
}
