<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-db', function () {
    return view('dbconn');
});

Route::prefix('api')->group(function () {
    Route::get('/assets', [AssetController::class, 'index']);  
    Route::post('/assets', [AssetController::class, 'store']);  
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']); 
    Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
    Route::post('/barang-masuk', [BarangMasukController::class, 'store']);
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
