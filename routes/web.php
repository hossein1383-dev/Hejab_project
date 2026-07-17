<?php

use Ipe\Sdk\Facades\SmsIr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatrController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileConrtoller;
use App\Http\Controllers\ContactUsController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/about', [AboutUsController::class, 'index'])->name('about');

Route::group(['prefix' => 'contact'], function () {
    Route::get('/index', [ContactUsController::class, 'index'])->name('contact_index');
    Route::post('/{contact}/destroy', [ContactUsController::class, 'destroy'])->name('contact_destroy');
    Route::post('/store', [ContactUsController::class, 'store'])->name('contact_store');
});

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product_show');
Route::get('/menu', [ProductController::class, 'menu'])->name('product_menu');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login_form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/check-otp', [AuthController::class, 'checkOtp'])->name('chekOtp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resendOtp');
});

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::prefix('profile')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [ProfileConrtoller::class, 'index'])->name('index_profile');
        Route::put('/{user}', [ProfileConrtoller::class, 'update'])->name('profile_update');
        Route::get('/orders', [ProfileConrtoller::class, 'orders'])->name('profile_orders');
        Route::get('/transactions', [ProfileConrtoller::class, 'transaction'])->name('profile_transactions');
    });
Route::prefix('addresses')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('addresses');
        Route::get('/create', [AddressController::class, 'create'])->name('addresses_create');
        Route::post('/', [AddressController::class, 'store'])->name('addresses_store');
        Route::get('/{address}/edit', [AddressController::class, 'edit'])->name('addresses_edit');
        Route::put('/{address}/edit', [AddressController::class, 'update'])->name('addresses_update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('addresses_destroy');
    });

Route::prefix('cart')
    ->group(function () {
        Route::get('/cart', [CatrController::class, 'index'])->name('cart_index');
        Route::get('/cart/add', [CatrController::class, 'add'])->name('cart_add');
        Route::post('/cart/decrement', [CatrController::class, 'decrement'])->name('decrement');
        Route::post('/cart/increment', [CatrController::class, 'increment'])->name('increment');
        Route::get('/remove', [CatrController::class, 'remove'])->name('cart_remove');
        Route::get('clear', [CatrController::class, 'clear'])->name('cart_clear');
    });

Route::prefix('payment')
    ->middleware('auth')
    ->group(function () {
        Route::post('/send', [PaymentController::class, 'send'])->name('payment_send');

        Route::get('/verify/{transaction}', [PaymentController::class, 'verify'])->name('payment_verify');
    });
