<?php

namespace App\Services\TBank;

use Illuminate\Support\Facades\Http;

class TBankClient
{
    public function __construct(private readonly ?string $baseUrl = null) {}

    public function initPayment(array $payload): array
    {
        return $this->post('/Init', $payload);
    }

    public function getPaymentState(array $payload): array
    {
        return $this->post('/GetState', $payload);
    }

    public function cancelOrRefundPayment(array $payload): array
    {
        return $this->post('/Cancel', $payload);
    }

    private function post(string $uri, array $payload): array
    {
        $base = $this->baseUrl ?? config('services.tbank.base_url');
        $response = Http::baseUrl($base)->post($uri, array_merge([
            'TerminalKey' => config('services.tbank.terminal_key'),
            'Password' => config('services.tbank.password'),
        ], $payload));

        return $response->json() ?? [];
    }
}
