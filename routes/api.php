<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;

Route::get('/assets', [AssetController::class, 'index']);
Route::get('/barang-masuk', [BarangMasukController::class, 'index']);
Route::post('/barang-masuk', [BarangMasukController::class, 'store']);
Route::get('/barang-keluar', [BarangKeluarController::class, 'index']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);
Route::get('/laporan', [LaporanController::class, 'index']);
