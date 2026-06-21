<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;

// Controller Admin 
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TanamanObatController as AdminTanaman;
use App\Http\Controllers\Admin\KategoriController as AdminKategori;
use App\Http\Controllers\Admin\AlbumController as AdminAlbum; 
use App\Http\Controllers\Admin\GaleriController as AdminGaleri;
use App\Http\Controllers\Admin\BeritaController as AdminBerita;
use App\Http\Controllers\Admin\UlasanController as AdminUlasan;
use App\Http\Controllers\Admin\UserController as AdminUser;

// Controller PJ
use App\Http\Controllers\Pj\DashboardController as PjDashboard;
use App\Http\Controllers\Pj\LaporanController as PjLaporan;

/* --- PUBLIC ROUTES --- */
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/tanaman/{slug}', [PublicController::class, 'detailTanaman'])->name('tanaman.detail');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('public.galeri');
Route::get('/galeri/album/{id}', [PublicController::class, 'showAlbum'])->name('galeri.album');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PublicController::class, 'detailBerita'])->name('berita.detail');
Route::get('/ulasan', [PublicController::class, 'ulasan'])->name('ulasan');
Route::post('/ulasan', [PublicController::class, 'kirimUlasan'])->name('ulasan.kirim');
Route::get('/qr/{slug}', [PublicController::class, 'scanQr'])->name('qr.scan');

/* --- AUTH ROUTES --- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password (Reset Password via Email)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('guest');


/* --- ADMIN ROUTES --- */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/profil', [AdminDashboard::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminDashboard::class, 'updateProfil'])->name('profil.update');
    
    Route::resource('tanaman', AdminTanaman::class);
    Route::get('/tanaman/{id}/qr-download', [AdminTanaman::class, 'downloadQr'])->name('tanaman.qr-download');
    Route::get('/tanaman/{id}/generate-qr', [AdminTanaman::class, 'generateQr'])->name('tanaman.generate-qr');
    Route::post('/tanaman/regenerate-all-qr', [AdminTanaman::class, 'regenerateAllQr'])->name('tanaman.regenerate-all-qr');
    
    Route::resource('kategori', AdminKategori::class);
    
    Route::resource('album', AdminAlbum::class); 
    
    Route::resource('galeri', AdminGaleri::class);
    Route::resource('berita', AdminBerita::class)->parameters(['berita' => 'berita']);
    Route::resource('user', AdminUser::class);
    
    // Route Saran internal Admin (Aman dari bentrokan rute PJ)
    Route::get('/ulasann', [AdminUlasan::class, 'index'])->name('ulasan.index');
    Route::get('/ulasan/{id}', [AdminUlasan::class, 'show'])->name('ulasan.show');
    Route::patch('/ulasan/{id}/toggle-display', [AdminUlasan::class, 'toggleDisplay'])->name('ulasan.toggle-display');
    Route::delete('/ulasan/{id}', [AdminUlasan::class, 'destroy'])->name('ulasan.destroy');
    
    // ⚡ PERBAIKAN AJAX UTAMA SINDI: Rute pengubah status ulasan otomatis di latar belakang saat detail dibuka
    Route::post('/ulasan/{id}/read-ajax', [AdminUlasan::class, 'readAjax'])->name('ulasan.readAjax');
});

/* --- PENANGGUNG JAWAB ROUTES (PROSES ISOLASI ROLE DIKUNCI BIAR TIDAK BENTROK) --- */
Route::prefix('pj')->name('pj.')->middleware(['auth', 'role:penanggungjawab'])->group(function () {
    Route::get('/dashboard', [PjDashboard::class, 'index'])->name('dashboard');
    Route::get('/profil', [PjDashboard::class, 'profil'])->name('profil');
    Route::put('/profil', [PjDashboard::class, 'updateProfil'])->name('profil.update');

    // Laporan
    $routingLaporan = PjLaporan::class;
    Route::get('/laporan/tanaman', [$routingLaporan, 'tanaman'])->name('laporan.tanaman');
    Route::get('/laporan/pengunjung', [$routingLaporan, 'pengunjung'])->name('laporan.pengunjung');
    Route::get('/laporan/export', [$routingLaporan, 'export'])->name('laporan.export');
    Route::get('/laporan-berita', [$routingLaporan, 'berita'])->name('laporan.berita');
    Route::get('/laporan-berita/cetak', [$routingLaporan, 'cetakBerita'])->name('laporan.berita.cetak');
    Route::get('/laporan-galeri', [$routingLaporan, 'galeri'])->name('laporan.galeri');
    Route::get('/laporan-galeri/cetak', [$routingLaporan, 'cetakGaleri'])->name('laporan.galeri.cetak');

    // PERBAIKAN: Dialihkan langsung ke fungsi ulasan() yang berada di dalam LaporanController
    Route::get('/ulasan', [$routingLaporan, 'ulasan'])->name('ulasan.index');
    
    // TAMBAHAN RUTE PENGAMAN: Meredam error ulasan.show di tombol Lihat agar halaman tidak crash
    Route::get('/ulasan/{id}', [$routingLaporan, 'cetakBerita'])->name('ulasan.show');
});

/* --- GLOBAL PUBLIC ROUTES (BEBAS DIAKSES SIAPA SAJA TANPA SYARAT LOGIN) --- */
// ⚡ FIX PERBAIKAN: Mengeluarkan rute pemindah bahasa ke luar grup PJ agar terbaca secara global oleh sistem
Route::get('lang/{lang}', [\App\Http\Controllers\LanguageController::class, 'switchLang'])->name('lang.switch');

// Rute pengaman untuk menjalankan migrasi database di production (Railway) secara manual & aman
Route::get('/run-migrations', function () {
    if (request('secret') !== 'sitobat123') {
        abort(403, 'Akses ditolak.');
    }
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Cache::forget('migrations_checked_v3');
        return '<h1>Migrasi Sukses!</h1><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return '<h1>Migrasi Gagal!</h1><pre>' . $e->getMessage() . '</pre>';
    }
});