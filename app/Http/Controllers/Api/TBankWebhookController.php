<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TBank\TBankPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TBankWebhookController extends Controller
{
    public function __invoke(Request $request, TBankPaymentService $service): JsonResponse
    {
        $service->handleNotification($request->all());
        return response()->json(['success' => true]);
    }
}
