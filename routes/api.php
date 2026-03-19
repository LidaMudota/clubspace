<?php

use App\Http\Controllers\Api\TBankWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/tbank', TBankWebhookController::class)->name('api.webhooks.tbank');
