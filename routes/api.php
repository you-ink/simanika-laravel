<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\NotificationController;

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
    Route::post('rapat', [MeetingController::class, 'store']);
    Route::put('rapat/{id}', [MeetingController::class, 'update']);
    Route::delete('rapat/{id}', [MeetingController::class, 'destroy']);
    Route::post('rapat/upload_notulensi', [MeetingController::class, 'upload_notulensi']);

    // Notifikasi
    Route::post('notifikasi', [NotificationController::class, 'store']);

    // Auth
    Route::post('akun', [AuthController::class, 'akun']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Hanya untuk testing, nanti ditaruh di group sanctum lagi
Route::get('artikel', [ArtikelController::class, 'index']);
Route::get('artikel/{id}', [ArtikelController::class, 'show']);

Route::get('rapat', [MeetingController::class, 'index']);
Route::get('rapat/{id}', [MeetingController::class, 'show']);

Route::get('notifikasi', [NotificationController::class, 'index']);
Route::get('notifikasi/{id}', [NotificationController::class, 'show']);

Route::post('login', [AuthController::class, 'login']);
