<?php

use App\Http\Controllers\Payment\BookingPaymentController;
use App\Http\Controllers\Refund\RefundController;
use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/events', [PublicPageController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [PublicPageController::class, 'event'])->name('events.show');
Route::get('/news', [PublicPageController::class, 'news'])->name('news.index');
Route::get('/news/{slug}', [PublicPageController::class, 'newsShow'])->name('news.show');
Route::get('/albums', [PublicPageController::class, 'albums'])->name('albums.index');
Route::get('/albums/{slug}', [PublicPageController::class, 'albumShow'])->name('albums.show');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/contacts', [PublicPageController::class, 'contacts'])->name('contacts');

Route::middleware('auth')->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/events', [AccountController::class, 'events'])->name('account.events');
    Route::get('/account/payments', [AccountController::class, 'payments'])->name('account.payments');
    Route::get('/account/refunds', [AccountController::class, 'refunds'])->name('account.refunds');

    Route::post('/bookings', [BookingPaymentController::class, 'store'])->name('bookings.store');
    Route::post('/refunds', [RefundController::class, 'store'])->name('refunds.store');
});

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
