<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::prefix('dashboard')->group(function () {
    // Rute untuk halaman utama dashboard
    Route::get('/', function () {
        return view('dashboard.main');
    })->name('dashboard.index');

     // Rute untuk halaman artikel di dashboard
    Route::get('/artikel', function () {
        return view('dashboard.article');
    })->name('dashboard.artikel');

    // Rute untuk halaman rapat di dashboard
    Route::get('/rapat', function () {
        return view('dashboard.meeting');
    })->name('dashboard.rapat');

    // Rute untuk halaman rapat di dashboard
    Route::get('/notifikasi', function () {
        return "view('dashboard.notification')";
    })->name('dashboard.notifikasi');

    // Rute untuk halaman rapat di dashboard
    Route::get('/user', function () {
        return view('dashboard.member');
    })->name('dashboard.user');
});
