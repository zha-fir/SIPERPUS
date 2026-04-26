<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OpacController;

// Public Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public OPAC / Katalog Buku
Route::get('/katalog', [OpacController::class, 'index'])->name('katalog.index');

// Temporary route to setup admin if seeder failed
Route::get('/setup-admin', function () {
    $user = \App\Models\User::firstOrNew(['email' => 'admin@siperpus.com']);
    $user->name = 'Administrator';
    // Using Hash::make manually to ensure it works correctly regardless of cast bugs
    $user->password = \Illuminate\Support\Facades\Hash::make('password');
    $user->save();
    
    return 'Akun admin berhasil dibuat paksa. Silakan ke <a href="/login">Halaman Login</a> dan gunakan email: admin@siperpus.com, password: password';
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Helpdesk Routes (Public)
Route::prefix('helpdesk')->group(function () {
    Route::get('/', [\App\Http\Controllers\HelpdeskController::class, 'create'])->name('helpdesk.create');
    Route::post('/submit', [\App\Http\Controllers\HelpdeskController::class, 'store'])->name('helpdesk.store');
    Route::get('/status', [\App\Http\Controllers\HelpdeskController::class, 'statusView'])->name('helpdesk.status.view');
});

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Insiden
    Route::get('/insiden', [\App\Http\Controllers\InsidenController::class, 'index'])->name('insiden.index');
    Route::get('/insiden/{id}', [\App\Http\Controllers\InsidenController::class, 'show'])->name('insiden.show');
    Route::put('/insiden/{id}', [\App\Http\Controllers\InsidenController::class, 'update'])->name('insiden.update');

    // Kunjungan (Buku Tamu)
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::post('/kunjungan/scan', [KunjunganController::class, 'storeScan'])->name('kunjungan.storeScan');
    Route::post('/kunjungan/umum', [KunjunganController::class, 'storeUmum'])->name('kunjungan.storeUmum');

    // Master Data Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/cetak-kartu', [AnggotaController::class, 'cetakKartu'])->name('anggota.cetak-kartu');
    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggota.show');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Master Data Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/cetak-barcode', [BukuController::class, 'cetakBarcode'])->name('buku.cetak-barcode');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Transaksi Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    
    // API Cek Barcode (Peminjaman POS)
    Route::get('/api/anggota/cek', [PeminjamanController::class, 'cekAnggota'])->name('api.anggota.cek');
    Route::get('/api/buku/cek', [PeminjamanController::class, 'cekBuku'])->name('api.buku.cek');
    Route::get('/api/anggota/pinjaman-aktif', [PengembalianController::class, 'pinjamanAktif'])->name('api.anggota.pinjaman-aktif');

    // Transaksi Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});
