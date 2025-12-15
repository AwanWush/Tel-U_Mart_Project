<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
//tambahan route
use App\Http\Controllers\UserGalonController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\UserProductController;


Route::get('/', function () {
    return redirect()->route('login');
});

// ==================== DASHBOARD SESUAI ROLE ==================== //
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Jika belum login → langsung tampilkan dashboard user umum (tanpa auth)
    if (!$user) {
        return view('dashboard.user');
    }

    // Jika login → arahkan sesuai role
    switch ($user->role_id) {
        case 1:
            return view('dashboard.superadmin'); // Super Admin wajib login
        case 2:
            return view('dashboard.admin');      // Admin wajib login
        case 3:
        default:
            return view('dashboard.user');       // User login pun ke dashboard user
    }
})->name('dashboard');


// ==================== Bawaan Breeze ==================== //
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ==================== SUPER ADMIN (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/kelola-admin', 'dashboard.superadmin')->name('admin.manage');
    Route::view('/laporan-bulanan', 'dashboard.superadmin')->name('laporan.bulanan');
    Route::view('/grafik-produk', 'dashboard.superadmin')->name('grafik.produk');
    Route::view('/gaji-admin', 'dashboard.superadmin')->name('gaji.admin');
});

// ==================== ADMIN (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/produk', 'dashboard.admin')->name('produk.index');
    Route::view('/kategori', 'dashboard.admin')->name('kategori.index');
    Route::view('/pesanan', 'dashboard.admin')->name('pesanan.index');
    Route::view('/penjualan-bulan-ini', 'dashboard.admin')->name('penjualan.bulanini');
    Route::view('/produk-laris', 'dashboard.admin')->name('produk.laris');
});

// ==================== USER (TIDAK WAJIB LOGIN) ==================== //
Route::group([], function () {
    Route::view('/produk-list', 'dashboard.user')->name('produk.list');
    Route::view('/pesanan-saya', 'dashboard.user')->name('pesanan.user');
    Route::view('/riwayat-pembelian', 'dashboard.user')->name('riwayat.pembelian');
    Route::view('/profil-saya', 'dashboard.user')->name('profil.user');
});

// ==================== CHECKOUT (WAJIB LOGIN) ==================== //
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/checkout', 'checkout.index')->name('checkout.index');
});

// ==================== FITUR TAMBAHAN: GALON & TOKEN LISTRIK ==================== //
Route::middleware(['auth'])->group(function () {

    // Token
    Route::get('/token-listrik', [UserTokenController::class, 'index'])->name('token.index');
    Route::post('/token-listrik/beli', [UserTokenController::class, 'store'])->name('token.store');

    // Riwayat Token
    Route::get('/token-listrik/riwayat', [UserTokenController::class, 'history'])->name('token.history');
    Route::get('/token-listrik/detail/{id}', [UserTokenController::class, 'detail'])->name('token.detail');

    // Galon
    Route::get('/galon', [UserGalonController::class, 'index'])->name('galon.index');
    Route::post('/galon/beli', [UserGalonController::class, 'store'])->name('galon.store');

    // Riwayat Galon
    Route::get('/galon/riwayat', [UserGalonController::class, 'history'])->name('galon.history');

    // Detail Galon
    Route::get('/galon/detail/{id}', [UserGalonController::class, 'detail'])->name('galon.detail');
});






