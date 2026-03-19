<?php

use App\Http\Controllers\Auth\OtpAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:6,1')->group(function () {
    Route::get('/auth/otp', [OtpAuthController::class, 'create'])->name('auth.otp.form');
    Route::post('/auth/otp/send', [OtpAuthController::class, 'send'])->name('auth.otp.send');
    Route::post('/auth/otp/verify', [OtpAuthController::class, 'verify'])->name('auth.otp.verify');
});

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('auth.social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('auth.social.callback');
