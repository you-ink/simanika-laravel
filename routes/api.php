<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PresensiRapatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Artikel
    Route::post('artikel', [ArtikelController::class, 'store'])->name('api.artikel.store');
    Route::put('artikel/{id}', [ArtikelController::class, 'update'])->name('api.artikel.update');
    Route::delete('artikel/{id}', [ArtikelController::class, 'destroy'])->name('api.artikel.delete');
    Route::post('rapat/upload_file', [RapatController::class, 'upload_file'])->name('api.artikel.upload_file');

    // Rapat
    Route::post('rapat', [RapatController::class, 'store'])->name('api.rapat.store');
    Route::put('rapat/{id}', [RapatController::class, 'update'])->name('api.rapat.update');
    Route::delete('rapat/{id}', [RapatController::class, 'destroy'])->name('api.rapat.delete');
    Route::post('rapat/upload_notulensi', [RapatController::class, 'upload_notulensi'])->name('api.rapat.upload_notulensi');

    // Presensi Rapat
    Route::post('presensi', [PresensiRapatController::class, 'store']);

    // Notifikasi
    Route::post('notifikasi', [NotificationController::class, 'store']);

    // Auth
    Route::post('akun', [AuthController::class, 'akun']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('lengkapi_profil', [AuthController::class, 'complete_profile']);
    Route::post('edit_profil', [AuthController::class, 'update_profile']);
    Route::post('ubah_password', [AuthController::class, 'update_password']);
});

// Hanya untuk testing, nanti ditaruh di group sanctum lagi
Route::get('artikel', [ArtikelController::class, 'index'])->name('api.artikel.index');
Route::get('artikel/{id}', [ArtikelController::class, 'show'])->name('api.artikel.detail');

Route::get('rapat', [RapatController::class, 'index'])->name('api.rapat.index');
Route::get('rapat/{id}', [RapatController::class, 'show'])->name('api.rapat.detail');

Route::get('notifikasi', [NotificationController::class, 'index']);
Route::get('notifikasi/{id}', [NotificationController::class, 'show']);

Route::get('user', [UserController::class, 'index']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
