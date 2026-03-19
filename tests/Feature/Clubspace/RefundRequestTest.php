<?php

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;

it('creates refund request', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $booking = Booking::query()->create(['user_id' => $user->id, 'event_id' => $event->id, 'status' => BookingStatus::Confirmed, 'amount' => 1000]);
    $payment = Payment::query()->create([
        'user_id' => $user->id,
        'booking_id' => $booking->id,
        'provider_payment_id' => 'p_3',
        'idempotency_key' => (string) str()->uuid(),
        'amount' => 1000,
        'status' => PaymentStatus::Paid,
    ]);

    $this->actingAs($user)->post('/refunds', [
        'payment_id' => $payment->id,
        'reason' => 'Не могу прийти',
    ])->assertSessionHas('status');

    $this->assertDatabaseCount('refund_requests', 1);
});
