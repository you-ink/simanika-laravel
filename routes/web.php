<?php

use Illuminate\Http\Response;
use App\Events\ContentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuncController;

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

Route::get('/detail', function () {
    return view('detail_article');
});

Route::get('/login', function () {
    FuncController::cek_user();
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    FuncController::cek_user();
    return view('auth.register');
})->name('register');

Route::prefix('dashboard')->group(function () {
    // Rute untuk halaman utama dashboard
    Route::get('/', function () {
        $user = FuncController::get_profile();
        return view('dashboard.main')->with('user', $user);
    })->name('dashboard.index');

     // Rute untuk halaman artikel di dashboard
    Route::get('/artikel', function () {
        $user = FuncController::get_profile();
        FuncController::set_access_status(1);
        return view('dashboard.article')->with('user', $user);
    })->name('dashboard.artikel');

    // Rute untuk halaman rapat di dashboard
    Route::get('/meeting', function () {
        $user = FuncController::get_profile();
        FuncController::set_access_status(1);
        return view('dashboard.meeting')->with('user', $user);
    })->name('dashboard.meeting');

    // Rute untuk halaman rapat di dashboard
    Route::get('/notifikasi', function () {
        $user = FuncController::get_profile();
        return view('dashboard.notification')->with('user', $user);
    })->name('dashboard.notifikasi');

    // Rute untuk halaman rapat di dashboard
    Route::get('/member', function () {
        $user = FuncController::get_profile();
        FuncController::set_access_status(1);
        FuncController::set_access_level(1);
        return view('dashboard.member')->with('user', $user);
    })->name('dashboard.member');

    // Rute untuk halaman rapat di dashboard
    Route::get('/user_profile', function () {
        $user = FuncController::get_profile();
        return view('dashboard.user_profile')->with('user', $user);
    })->name('dashboard.user_profile');

     // Rute untuk halaman artikel di dashboard
     Route::get('/presensi/{id}', function () {
        $user = FuncController::get_profile();
        return view('dashboard.presensi')->with('user', $user);
    })->name('dashboard.presensi');
});
