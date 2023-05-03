<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtikelController;

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


    // Auth
    Route::post('akun', [AuthController::class, 'akun']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Hanya untuk testing, nanti ditaruh di group sanctum lagi
Route::get('artikel', [ArtikelController::class, 'index']);
Route::get('artikel/{id}', [ArtikelController::class, 'show']);

Route::post('login', [AuthController::class, 'login']);
