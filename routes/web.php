<?php

use App\Http\Controllers\Media\CardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Media\MediaController;


/**
 * ROUTE PUBLIC
 **/

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/kegiatan/{slug}', [LandingPageController::class, 'detailKegiatan'])->name('landing.kegiatan.detail');


/**
 * ROUTE AUTENTIKASI
 **/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->group(function () {

    // Halaman Utama Dashboard Media
    Route::get('/', [MediaController::class, 'index'])->name('media.dashboard');

    // Profil perusahan
    Route::get('/profil', [MediaController::class, 'editProfil'])->name('media.profil.edit');
    Route::put('/profil/update', [MediaController::class, 'updateProfil'])->name('media.profil.update');

    // Card 
    Route::get('/card', [CardController::class, 'index'])->name('card.index');
});

