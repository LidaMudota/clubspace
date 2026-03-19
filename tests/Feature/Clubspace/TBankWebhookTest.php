<?php

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;

it('confirms payment on webhook', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $booking = Booking::query()->create(['user_id' => $user->id, 'event_id' => $event->id, 'amount' => 1000, 'status' => BookingStatus::Draft]);
    $payment = Payment::query()->create(['user_id' => $user->id, 'booking_id' => $booking->id, 'provider_payment_id' => 'p_1', 'idempotency_key' => (string) str()->uuid(), 'amount' => 1000, 'status' => PaymentStatus::Pending]);

    $this->postJson('/api/webhooks/tbank', ['PaymentId' => 'p_1', 'Status' => 'CONFIRMED'])->assertOk();

    expect($payment->fresh()->status)->toBe(PaymentStatus::Paid);
});

it('does not re-confirm webhook twice', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $booking = Booking::query()->create(['user_id' => $user->id, 'event_id' => $event->id, 'amount' => 1000, 'status' => BookingStatus::Confirmed]);
    Payment::query()->create(['user_id' => $user->id, 'booking_id' => $booking->id, 'provider_payment_id' => 'p_2', 'idempotency_key' => (string) str()->uuid(), 'amount' => 1000, 'status' => PaymentStatus::Paid]);

    $this->postJson('/api/webhooks/tbank', ['PaymentId' => 'p_2', 'Status' => 'CONFIRMED'])->assertOk();

    $this->assertDatabaseCount('notification_logs', 1);
});
