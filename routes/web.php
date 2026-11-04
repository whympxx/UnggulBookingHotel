<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hotels/search', [HomeController::class, 'search'])->name('hotels.search');
Route::get('/layanan', [HomeController::class, 'services'])->name('services');
Route::get('/properties', [HomeController::class, 'properties'])->name('properties');
Route::get('/agents', [HomeController::class, 'agents'])->name('agents');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::view('/contact-admin', 'pages.contact-admin')->name('contact');
Route::view('/masuk', 'auth.select')->name('auth.select');

/*
|--------------------------------------------------------------------------
| Autentikasi (user, agent, admin)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    foreach (['user' => '', 'agent' => 'agent/', 'admin' => 'admin/'] as $role => $prefix) {
        $name = $role === 'user' ? '' : $role.'.';
        Route::get($prefix.'login', [AuthController::class, 'showLogin'])->defaults('role', $role)->name($name.'login');
        Route::post($prefix.'login', [AuthController::class, 'login'])->defaults('role', $role)->middleware('throttle:10,1');
        Route::get($prefix.'register', [AuthController::class, 'showRegister'])->defaults('role', $role)->name($name.'register');
        Route::post($prefix.'register', [AuthController::class, 'register'])->defaults('role', $role);
    }

    Route::get('forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'email'])->name('password.email')->middleware('throttle:5,1');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Akun (semua role yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('settings', [AccountController::class, 'settings'])->name('settings');
    Route::get('settings/account', [AccountController::class, 'security'])->name('account.security');
    Route::get('profile', [AccountController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::get('settings/password', [AccountController::class, 'editPassword'])->name('password.edit');
    Route::put('settings/password', [AccountController::class, 'updatePassword'])->name('password.change');
});
// Bahasa boleh diganti tanpa login
Route::get('settings/language', [AccountController::class, 'language'])->name('language');

/*
|--------------------------------------------------------------------------
| Keranjang, booking & pembayaran (customer)
|--------------------------------------------------------------------------
*/
Route::middleware('role:user')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    // checkout harus didaftarkan sebelum cart/{hotel}
    Route::get('cart/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkout');
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout.store');
    Route::post('cart/{hotel}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/{hotel}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('hotels/{hotel}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('hotels/{hotel}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('hotels/{hotel}/reviews', [HotelController::class, 'review'])->name('reviews.store');
    Route::delete('hotels/{hotel}/reviews', [HotelController::class, 'destroyReview'])->name('reviews.destroy');
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/{hotel}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('payment/{payment:code}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('payment/{payment:code}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
});

// Invoice bisa dibuka pemilik pembayaran atau admin
Route::get('payment/{payment:code}/invoice', [PaymentController::class, 'invoice'])->middleware('role:user,admin')->name('payment.invoice');

/*
|--------------------------------------------------------------------------
| Agent
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->middleware('role:agent')->group(function () {
    Route::get('/', [Agent\DashboardController::class, 'index'])->name('dashboard');
    Route::get('reports', [Agent\DashboardController::class, 'reports'])->name('reports');
    Route::get('hotels', [Agent\HotelController::class, 'index'])->name('hotels.index');
    Route::post('hotels', [Agent\HotelController::class, 'store'])->name('hotels.store');
    Route::get('hotels/{hotel:id}', [Agent\HotelController::class, 'show'])->name('hotels.show');
    Route::put('hotels/{hotel:id}', [Agent\HotelController::class, 'update'])->name('hotels.update');
    Route::delete('hotels/{hotel:id}', [Agent\HotelController::class, 'destroy'])->name('hotels.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/data', [Admin\DashboardController::class, 'data'])->name('dashboard.data');
    Route::post('profile-photo', [Admin\DashboardController::class, 'uploadPhoto'])->name('profile.photo');

    Route::get('locations', [Admin\HotelController::class, 'index'])->name('hotels.index');
    Route::post('locations', [Admin\HotelController::class, 'store'])->name('hotels.store');
    Route::put('locations/{hotel:id}', [Admin\HotelController::class, 'update'])->name('hotels.update');
    Route::delete('locations/{hotel:id}', [Admin\HotelController::class, 'destroy'])->name('hotels.destroy');

    Route::get('properties', [Admin\RoomController::class, 'index'])->name('rooms.index');
    Route::post('properties/{hotel:id}/rooms', [Admin\RoomController::class, 'store'])->name('rooms.store');
    Route::put('rooms/{room}', [Admin\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [Admin\RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::put('orders/{booking}', [Admin\OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{booking}', [Admin\OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('agents', [Admin\AgentController::class, 'index'])->name('agents.index');
    Route::post('agents', [Admin\AgentController::class, 'store'])->name('agents.store');
    Route::put('agents/{agent}', [Admin\AgentController::class, 'update'])->name('agents.update');
    Route::delete('agents/{agent}', [Admin\AgentController::class, 'destroy'])->name('agents.destroy');

    Route::get('promos', [Admin\PromoController::class, 'index'])->name('promos.index');
    Route::post('promos', [Admin\PromoController::class, 'store'])->name('promos.store');
    Route::put('promos/{promo}', [Admin\PromoController::class, 'update'])->name('promos.update');
    Route::delete('promos/{promo}', [Admin\PromoController::class, 'destroy'])->name('promos.destroy');

    Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
