<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::post('artikel', [ArtikelController::class, 'store']);
    Route::put('artikel/{id}', [ArtikelController::class, 'update'])->middleware('artikel-owner');
    Route::delete('artikel/{id}', [ArtikelController::class, 'destroy'])->middleware('artikel-owner');

    // Rapat
    Route::post('rapat', [RapatController::class, 'store']);
    Route::put('rapat/{id}', [RapatController::class, 'update']);
    Route::delete('rapat/{id}', [RapatController::class, 'destroy']);
    Route::post('rapat/upload_notulensi', [RapatController::class, 'upload_notulensi']);

    // Presensi Rapat
    Route::post('presensi', [PresensiRapatController::class, 'store']);

    // Notifikasi
    Route::post('notifikasi', [NotificationController::class, 'store']);

    // Auth
    Route::post('akun', [AuthController::class, 'akun']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Hanya untuk testing, nanti ditaruh di group sanctum lagi
Route::get('artikel', [ArtikelController::class, 'index']);
Route::get('artikel/{id}', [ArtikelController::class, 'show']);

Route::get('rapat', [RapatController::class, 'index']);
Route::get('rapat/{id}', [RapatController::class, 'show']);

Route::get('notifikasi', [NotificationController::class, 'index']);
Route::get('notifikasi/{id}', [NotificationController::class, 'show']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('lengkapi-profil', [AuthController::class, 'complete_profile']);
