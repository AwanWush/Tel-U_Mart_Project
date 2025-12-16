<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->get(
    '/dashboard/admin',
    [DashboardController::class, 'admin']
)->name('dashboard.admin');

Route::middleware(['auth', 'verified'])->get(
    '/dashboard/superadmin',
    [DashboardController::class, 'superadmin']
)->name('dashboard.superadmin');

Route::get('/dashboard/user', [DashboardController::class, 'user'])
    ->name('dashboard.user');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class,'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class,'remove'])->name('cart.remove');
});

Route::middleware(['auth'])->post(
    '/checkout/selected',
    [CheckoutController::class, 'selected']
)->name('checkout.selected');

Route::middleware(['auth'])->group(function () {

    Route::get('/wishlist', [WishlistController::class,'index'])
        ->name('wishlist.index');

    Route::post('/wishlist', [WishlistController::class,'store'])
        ->name('wishlist.store');

    Route::post('/wishlist/remove-selected', [WishlistController::class,'removeSelected'])
        ->name('wishlist.removeSelected');

    Route::post('/wishlist/move-to-cart', [WishlistController::class,'moveToCart'])
        ->name('wishlist.moveToCart');

    Route::delete('/wishlist/{id}', [WishlistController::class,'destroy'])
        ->name('wishlist.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('produk', ProdukController::class)->except(['show']);
    Route::resource('kategori', KategoriProdukController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-selected', [NotificationController::class, 'readSelected'])
        ->name('notifications.readSelected');

    Route::post('/notifications/delete-selected', [NotificationController::class, 'deleteSelected'])
        ->name('notifications.deleteSelected');
});



Route::resource('pembayaran', PembayaranController::class)
    ->except(['show', 'edit', 'update']);

Route::post('/pembayaran', [PembayaranController::class, 'store'])
    ->name('pembayaran.store');

Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])
    ->name('pembayaran.destroy');

Route::post('/payment/create', [PembayaranController::class, 'createPayment'])
    ->name('payment.create');

Route::post('/payment/callback', [PembayaranController::class, 'callback'])
    ->name('payment.callback');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
