<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvacuationRequestController;
use App\Http\Controllers\FloodReportController;
use App\Http\Controllers\PublicCitizenController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// ── Public pages ──────────────────────────────────────────────────────────────
Route::get('/', fn () => view('home'))->name('home');
Route::get('/peta-banjir', fn () => view('peta-banjir'))->name('peta-banjir');
Route::get('/lokasi-pengungsian', fn () => view('lokasi-pengungsian'))->name('lokasi-pengungsian');
Route::get('/panduan-evakuasi', fn () => view('panduan-evakuasi'))->name('panduan-evakuasi');
Route::get('/lapor-banjir', [FloodReportController::class, 'publicCreate'])->name('lapor-banjir');
Route::post('/lapor-banjir', [FloodReportController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('lapor-banjir.store');
Route::get('/permintaan-evakuasi', [PublicCitizenController::class, 'evacuationForm'])->name('permintaan-evakuasi');
Route::post('/permintaan-evakuasi', [PublicCitizenController::class, 'submitEvacuationRequest'])
    ->middleware('throttle:3,1')
    ->name('permintaan-evakuasi.store');
Route::match(['get', 'post'], '/cek-status', [PublicCitizenController::class, 'track'])
    ->middleware('throttle:6,1')
    ->name('status-warga');

// ── Auth pages ────────────────────────────────────────────────────────────────
Route::get('/masuk', fn () => view('auth.masuk'))->name('masuk');
Route::post('/masuk', [AuthController::class, 'login'])->name('login');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
Route::get('/daftar', fn () => view('auth.daftar'))->name('daftar');
Route::post('/daftar', [RegisterController::class, 'register'])->name('register');
Route::get('/lupa-sandi', fn () => view('auth.lupa-sandi'))->name('lupa-sandi');
Route::post('/lupa-sandi', [AuthController::class, 'sendResetLink'])
    ->middleware('throttle:3,1')
    ->name('password.email');
Route::get('/reset-sandi/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-sandi', [AuthController::class, 'resetPassword'])
    ->middleware('throttle:6,1')
    ->name('password.update');

// ── Dashboard Masyarakat ──────────────────────────────────────────────────────
Route::prefix('dashboard')->name('dashboard.')
    ->middleware(['auth', 'active', 'role:masyarakat'])
    ->group(function () {
        Route::get('/', fn () => view('dashboard.beranda'))->name('beranda');
        Route::get('/peta-banjir', fn () => view('dashboard.peta-banjir'))->name('peta-banjir');
        Route::get('/laporkan-banjir', [FloodReportController::class, 'create'])->name('laporan-banjir');
        Route::post('/laporkan-banjir', [FloodReportController::class, 'store'])->name('laporan-banjir.store');
        Route::get('/laporan-saya', [FloodReportController::class, 'mine'])->name('laporan-saya');
        Route::get('/rute-evakuasi', fn () => view('dashboard.rute-evakuasi'))->name('rute-evakuasi');
        Route::get('/lokasi-pengungsian', fn () => view('dashboard.lokasi-pengungsian'))->name('lokasi-pengungsian');
        Route::get('/permintaan-evakuasi', [PublicCitizenController::class, 'evacuationForm'])->name('permintaan-evakuasi');
        Route::get('/notifikasi', fn () => view('dashboard.notifikasi'))->name('notifikasi');
        Route::get('/profil', fn () => view('dashboard.profil'))->name('profil');
    });

// ── Dashboard Petugas BPBD ────────────────────────────────────────────────────
Route::prefix('petugas')->name('petugas.')
    ->middleware(['auth', 'active', 'role:petugas_bpbd'])
    ->group(function () {
        // Operasional
        Route::get('/', fn () => view('petugas.dashboard'))->name('dashboard');
        Route::get('/peta-monitoring', fn () => view('petugas.peta-monitoring'))->name('peta-monitoring');
        Route::get('/verifikasi-laporan', [FloodReportController::class, 'verificationQueue'])->name('verifikasi-laporan');
        Route::post('/verifikasi-laporan/{report}', [FloodReportController::class, 'verify'])->name('verifikasi-laporan.update');
        Route::get('/laporan/{report}/foto/{photo}', [FloodReportController::class, 'photo'])->name('laporan-foto');
        Route::get('/data-kejadian', fn () => view('petugas.data-kejadian'))->name('data-kejadian');
        Route::get('/kondisi-jalan', fn () => view('petugas.kondisi-jalan'))->name('kondisi-jalan');
        Route::get('/rute-evakuasi', fn () => view('petugas.rute-evakuasi'))->name('rute-evakuasi');
        Route::get('/permintaan-evakuasi', [EvacuationRequestController::class, 'index'])->name('permintaan-evakuasi');
        Route::patch('/permintaan-evakuasi/{evacuationRequest}', [EvacuationRequestController::class, 'update'])->name('permintaan-evakuasi.update');
        Route::get('/lokasi-pengungsian', fn () => view('petugas.lokasi-pengungsian'))->name('lokasi-pengungsian');
        // Logistik
        Route::get('/dashboard-logistik', fn () => view('petugas.dashboard-logistik'))->name('dashboard-logistik');
        Route::get('/stok-bantuan', fn () => view('petugas.stok-bantuan'))->name('stok-bantuan');
        Route::get('/kebutuhan-logistik', fn () => view('petugas.kebutuhan-logistik'))->name('kebutuhan-logistik');
        Route::get('/prioritas-kebutuhan', fn () => view('petugas.prioritas-kebutuhan'))->name('prioritas-kebutuhan');
        Route::get('/alokasi-bantuan', fn () => view('petugas.alokasi-bantuan'))->name('alokasi-bantuan');
        Route::get('/penyaluran-bantuan', fn () => view('petugas.penyaluran-bantuan'))->name('penyaluran-bantuan');
        Route::get('/riwayat-logistik', fn () => view('petugas.riwayat-logistik'))->name('riwayat-logistik');
        // Laporan
        Route::get('/statistik', fn () => view('petugas.statistik'))->name('statistik');
        Route::get('/profil', fn () => view('petugas.profil'))->name('profil');
    });

// ── Dashboard Koordinator Relawan ─────────────────────────────────────────────
Route::prefix('koordinator')->name('koordinator.')
    ->middleware(['auth', 'active', 'role:koordinator_relawan'])
    ->group(function () {
        // Relawan
        Route::get('/', fn () => view('koordinator.dashboard'))->name('dashboard');
        Route::get('/kebutuhan-relawan', fn () => view('koordinator.kebutuhan-relawan'))->name('kebutuhan-relawan');
        Route::get('/data-relawan', fn () => view('koordinator.data-relawan'))->name('data-relawan');
        Route::get('/ketersediaan-relawan', fn () => view('koordinator.ketersediaan-relawan'))->name('ketersediaan-relawan');
        Route::get('/alokasi-relawan', fn () => view('koordinator.alokasi-relawan'))->name('alokasi-relawan');
        Route::get('/penugasan-aktif', fn () => view('koordinator.penugasan-aktif'))->name('penugasan-aktif');
        Route::get('/riwayat-penugasan', fn () => view('koordinator.riwayat-penugasan'))->name('riwayat-penugasan');
        // Logistik
        Route::get('/dashboard-logistik', fn () => view('koordinator.dashboard-logistik'))->name('dashboard-logistik');
        Route::get('/bantuan-dihimpun', fn () => view('koordinator.bantuan-dihimpun'))->name('bantuan-dihimpun');
        Route::get('/kebutuhan-lapangan', fn () => view('koordinator.kebutuhan-lapangan'))->name('kebutuhan-lapangan');
        Route::get('/kebutuhan-berdasarkan-prioritas', fn () => view('koordinator.kebutuhan-berdasarkan-prioritas'))->name('kebutuhan-berdasarkan-prioritas');
        Route::get('/alokasi-penyaluran', fn () => view('koordinator.alokasi-penyaluran'))->name('alokasi-penyaluran');
        Route::get('/konfirmasi-penerimaan', fn () => view('koordinator.konfirmasi-penerimaan'))->name('konfirmasi-penerimaan');
        Route::get('/riwayat-distribusi', fn () => view('koordinator.riwayat-distribusi'))->name('riwayat-distribusi');
        // Lainnya
        Route::get('/laporan-kegiatan', fn () => view('koordinator.laporan-kegiatan'))->name('laporan-kegiatan');
        Route::get('/profil', fn () => view('koordinator.profil'))->name('profil');
    });

// ── Dashboard Admin Sistem ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')
    ->middleware(['auth', 'active', 'role:admin_sistem'])
    ->group(function () {
        Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/manajemen-pengguna', [AdminController::class, 'manajemenPengguna'])->name('manajemen-pengguna');
        Route::post('/manajemen-pengguna', [AdminController::class, 'tambahPengguna'])->name('manajemen-pengguna.store');
        Route::patch('/manajemen-pengguna/{user}/toggle', [AdminController::class, 'toggleStatus'])->name('manajemen-pengguna.toggle');
        Route::delete('/manajemen-pengguna/{user}', [AdminController::class, 'hapusPengguna'])->name('manajemen-pengguna.hapus');
        Route::get('/peran-hak-akses', fn () => view('admin.peran-hak-akses'))->name('peran-hak-akses');
        Route::get('/log-aktivitas', fn () => view('admin.log-aktivitas'))->name('log-aktivitas');
        Route::get('/pengaturan-sistem', fn () => view('admin.pengaturan-sistem'))->name('pengaturan-sistem');
        Route::get('/profil', fn () => view('admin.profil'))->name('profil');
    });
