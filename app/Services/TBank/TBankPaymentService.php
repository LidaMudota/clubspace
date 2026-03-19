<?php

namespace App\Services\TBank;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\NotificationLog;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class TBankPaymentService
{
    public function __construct(private readonly TBankClient $client) {}

    public function initPayment(Booking $booking): Payment
    {
        return DB::transaction(function () use ($booking) {
            $payment = Payment::query()->create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'provider' => 'tbank',
                'idempotency_key' => (string) str()->uuid(),
                'status' => PaymentStatus::Pending,
                'amount' => $booking->amount,
                'currency' => 'RUB',
            ]);

            $response = $this->client->initPayment([
                'Amount' => $booking->amount,
                'OrderId' => (string) $payment->id,
                'NotificationURL' => config('services.tbank.notification_url'),
            ]);

            $payment->update([
                'provider_payment_id' => $response['PaymentId'] ?? null,
                'raw_notification' => $response,
            ]);

            return $payment;
        });
    }

    public function handleNotification(array $payload): Payment
    {
        return DB::transaction(function () use ($payload) {
            NotificationLog::query()->create([
                'channel' => 'tbank_webhook',
                'type' => 'payment_notification',
                'recipient' => 'system',
                'payload' => $payload,
                'status' => 'received',
            ]);

            $payment = Payment::query()->where('provider_payment_id', $payload['PaymentId'] ?? null)->lockForUpdate()->firstOrFail();

            if ($payment->status === PaymentStatus::Paid) {
                return $payment;
            }

            if (($payload['Status'] ?? null) === 'CONFIRMED') {
                $payment->update(['status' => PaymentStatus::Paid, 'paid_at' => now(), 'raw_notification' => $payload]);
                $payment->booking()->update(['status' => BookingStatus::Confirmed, 'confirmed_at' => now()]);
            }

            return $payment;
        });
    }

    public function getPaymentState(Payment $payment): array
    {
        return $this->client->getPaymentState(['PaymentId' => $payment->provider_payment_id]);
    }

    public function cancelOrRefundPayment(Payment $payment): array
    {
        return $this->client->cancelOrRefundPayment(['PaymentId' => $payment->provider_payment_id]);
    }
}
