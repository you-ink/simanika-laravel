<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OtherController;
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
    Route::get('artikel_baru', [ArtikelController::class, 'new_article'])->name('api.artikel.baru');
    Route::post('artikel', [ArtikelController::class, 'store']);
    Route::put('artikel/{id}', [ArtikelController::class, 'update'])->middleware('artikel-owner');
    Route::delete('artikel/{id}', [ArtikelController::class, 'destroy'])->middleware('artikel-owner');

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
    Route::post('akun', [AuthController::class, 'akun'])->name('api.akun');
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('lengkapi_profil', [AuthController::class, 'complete_profile'])->name('api.lengkapi_profile');

    // User
    Route::post('edit_profil', [UserController::class, 'update_profile'])->name('api.user.edit_profile');
    Route::post('ubah_password', [UserController::class, 'update_password'])->name('api.user.ubah_password');
    Route::post('atur_wawancara', [UserController::class, 'set_interview'])->name('api.user.atur_wawancara');
    Route::post('terima', [UserController::class, 'accept_applicant'])->name('api.user.terima');
    Route::post('tolak', [UserController::class, 'decline_applicant'])->name('api.user.tolak');

    // Lain-lain
    Route::get('divisi', [OtherController::class, 'get_divisi'])->name('api.divisi');
    Route::get('jabatan', [OtherController::class, 'get_jabatan'])->name('api.jabatan');
});

// Hanya untuk testing, nanti ditaruh di group sanctum lagi
Route::get('artikel', [ArtikelController::class, 'index']);
Route::get('artikel/{id}', [ArtikelController::class, 'show']);

Route::get('rapat', [RapatController::class, 'index'])->name('api.rapat.index');
Route::get('rapat/{id}', [RapatController::class, 'show'])->name('api.rapat.detail');

Route::get('notifikasi', [NotificationController::class, 'index']);
Route::get('notifikasi/{id}', [NotificationController::class, 'show']);

Route::get('user', [UserController::class, 'index'])->name('api.user.index');

Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('register', [AuthController::class, 'register'])->name('api.register');
