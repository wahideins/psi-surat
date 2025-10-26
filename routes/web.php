<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesFirestore;
use App\Http\Controllers\Akun\RegistrasiController;
use App\Http\Controllers\Akun\MasukController;
use App\Http\Controllers\Warga\BiodataController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\AjukanSuratController;
use App\Http\Controllers\Warga\RiwayatSuratController;

use App\Http\Controllers\Kelurahan\DashboardKelurahan;
use App\Http\Controllers\Kelurahan\KependudukanController;
use App\Http\Controllers\Kelurahan\KelolaRTRWController;

Route::get('/', function () {
    return view('landing-pages');
});

//WARGA
Route::middleware(['web', 'verified', 'role:warga'])->group(function () {
    Route::get('/warga/dashboard',[DashboardController::class,'tampilkanHalaman'])->name('dashboardWarga'); //DASHBOARD

    //BIODATA
    Route::get('/warga/biodata', [BiodataController::class, 'tampilkanHalaman'])->name('biodataWarga'); //BIODATA
    //BIODATA

    //SURAT MENYURAT
    Route::get('/warga/ajukan-surat', [AjukanSuratController::class, 'tampilkanHalaman'])->name('ajukanSurat'); //MENAMPILKAN HALAMAN AJUKAN SURAT
    Route::post('/warga/ajukan-surat/preview', [AjukanSuratController::class, 'previewSurat'])->name('warga.ajukanSurat.preview'); //MENAMPILKAN PREVIEW SURAT
    Route::post('/warga/ajukan-surat/submit', [AjukanSuratController::class, 'submitForm'])->name('warga.ajukanSurat.submit'); //SUBMIT SURAT
    Route::get('/warga/ajukan-surat/cetak', [AjukanSuratController::class, 'cetakSurat'])->name('cetakSurat'); //CETAK SURAT
    Route::get('/warga/riwayat-surat', [RiwayatSuratController::class, 'tampilkanHalaman'])->name('warga.riwayatSurat'); //RIWAYAT SURAT MENYURAT
    //SURAT MENYURAT

});

//KELURAHAN
Route::middleware(['web', 'verified', 'role:kelurahan'])->group(function () {
    Route::get('/kelurahan/dashboard',[DashboardKelurahan::class,'tampilkanHalaman'])->name('dashboardKelurahan'); //DASHBOARD
    Route::get('/kelurahan/daftar-warga',[KependudukanController::class,'getWarga'])->name('daftarWarga'); //DAFTAR WARGA
    Route::get('/kelurahan/kepala-keluarga',[KependudukanController::class,'getKepalaKeluarga'])->name('kepalaKeluarga'); //DAFTAR WARGA
    Route::get('/kelurahan/detail-warga/{uid}',[KependudukanController::class,'detailWarga'])->name('detailWarga'); //DETAIL WARGA
    Route::get('kelurahan/warga/{field}/{value}', [KependudukanController::class, 'getJabatan'])->name('jabatanWarga'); //RTRWKEPALAKELUARGA
    Route::get('kelurahan/jabatan/rtaktif', [KependudukanController::class, 'halamanRT'])->name('halamanRT'); //RTRWKEPALAKELUARGA
    Route::get('kelurahan/jabatan/rwaktif', [KependudukanController::class, 'halamanRW'])->name('halamanRW'); //RTRWKEPALAKELUARGA
    
    Route::get('kelurahan/kelola/rtrw', [KelolaRTRWController::class, 'index'])->name('kelolaRTRW'); //RTRWKEPALAKELUARGA
    Route::get('/kelurahan/cari-warga', [KelolaRTRWController::class, 'cariWarga'])->name('cariWarga');
    
    Route::post('/kelurahan/simpan-rtrw', [KelolaRTRWController::class, 'simpanRTRW'])->name('simpanRTRW');
    Route::get('/kelurahan/simpan-rt-rw/cek', [KelolaRTRWController::class, 'cekRTRW']);


});


Route::middleware('web')->group(function () {
    Route::get('/login', [MasukController::class, 'tampilkanForm'])->name('login');
    Route::post('/login', [MasukController::class, 'login'])->name('login.submit');
    Route::get('/logout', [MasukController::class, 'logout'])->name('logout');
});

// Register
Route::get('/register', [RegistrasiController::class,'tampilkanForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'submitForm'])->name('form.user.submit');


Route::get('/google-play', function () {
    return redirect()->away('https://play.google.com/store/apps/details?id=');
})->name('google-play');

Route::get('/tes', [TesFirestore::class,'index']);
