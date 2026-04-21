<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Kunjungan (Buku Tamu)
Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
Route::post('/kunjungan/scan', [KunjunganController::class, 'storeScan'])->name('kunjungan.storeScan');
Route::post('/kunjungan/umum', [KunjunganController::class, 'storeUmum'])->name('kunjungan.storeUmum');

// Master Data Anggota
Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');

// Master Data Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

// Transaksi Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

// Transaksi Pengembalian
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
