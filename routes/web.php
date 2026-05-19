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
use App\Http\Controllers\Admin\SaranController as AdminSaran;
use App\Http\Controllers\Admin\UserController as AdminUser;

// Controller PJ
use App\Http\Controllers\Pj\DashboardController as PjDashboard;
use App\Http\Controllers\Pj\LaporanController as PjLaporan;
use App\Http\Controllers\Pj\SaranController as PjSaran;

/* --- PUBLIC ROUTES --- */
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/tanaman/{slug}', [PublicController::class, 'detailTanaman'])->name('tanaman.detail');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('public.galeri');
Route::get('/galeri/album/{id}', [PublicController::class, 'showAlbum'])->name('galeri.album');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PublicController::class, 'detailBerita'])->name('berita.detail');
Route::get('/saran', [PublicController::class, 'saran'])->name('saran');
Route::post('/saran', [PublicController::class, 'kirimSaran'])->name('saran.kirim');
Route::view('/sitobat-ai', 'public.sitobat-ai')->name('sitobat-ai');
Route::get('/qr/{slug}', [PublicController::class, 'scanQr'])->name('qr.scan');

/* --- AUTH ROUTES --- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* --- ADMIN ROUTES --- */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/profil', [AdminDashboard::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminDashboard::class, 'updateProfil'])->name('profil.update');
    
    Route::resource('tanaman', AdminTanaman::class);
    Route::get('/tanaman/{id}/qr-download', [AdminTanaman::class, 'downloadQr'])->name('tanaman.qr-download');
    Route::get('/tanaman/{id}/generate-qr', [AdminTanaman::class, 'generateQr'])->name('tanaman.generate-qr');
    
    Route::resource('kategori', AdminKategori::class);
    
    Route::resource('album', AdminAlbum::class); 
    
    Route::resource('galeri', AdminGaleri::class);
    Route::resource('berita', AdminBerita::class)->parameters(['berita' => 'berita']);
    Route::resource('user', AdminUser::class);
    
    Route::get('/saran', [AdminSaran::class, 'index'])->name('saran.index');
    Route::get('/saran/{id}', [AdminSaran::class, 'show'])->name('saran.show');
    Route::patch('/saran/{id}/toggle-display', [AdminSaran::class, 'toggleDisplay'])->name('saran.toggle-display');
    Route::delete('/saran/{id}', [AdminSaran::class, 'destroy'])->name('saran.destroy');
});

/* --- PENANGGUNG JAWAB ROUTES (AKSES DIKUNCI BYPASS BIAR NYAMAN) --- */
Route::prefix('pj')->name('pj.')->middleware(['auth'])->group(function () {
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

    // Saran PJ
    $routingSaran = PjSaran::class;
    Route::get('/saran', [$routingSaran, 'index'])->name('saran.index');
    Route::get('/saran/create', [$routingSaran, 'create'])->name('saran.create');
    Route::post('/saran', [$routingSaran, 'store'])->name('saran.store');
    Route::get('/saran/{id}', [$routingSaran, 'show'])->name('saran.show');
    Route::delete('/saran/{id}', [$routingSaran, 'destroy'])->name('saran.destroy');
});