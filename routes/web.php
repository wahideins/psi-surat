<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesFirestore;
use App\Http\Controllers\Akun\RegistrasiController;
use App\Http\Controllers\Akun\MasukController;

Route::get('/', function () {
    return view('landing-pages');
});

Route::middleware(['verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('warga.dashboardWarga');
    })->name('dashboard');
});

Route::get('/login', [MasukController::class, 'tampilkanForm'])->name('login');
Route::post('/login', [MasukController::class, 'login'])->name('login.submit');
Route::get('/logout', [MasukController::class, 'logout'])->name('logout');


Route::get('/google-play', function () {
    return redirect()->away('https://play.google.com/store/apps/details?id=');
})->name('google-play');

Route::get('/tes', [TesFirestore::class,'index']);

// Register
Route::get('/register', [RegistrasiController::class,'tampilkanForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'submitForm'])->name('form.user.submit');