<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Http;

it('does not allow booking when no free seats', function () {
    $event = Event::factory()->create(['capacity' => 1]);
    $existingUser = User::factory()->create();
    Booking::query()->create([
        'user_id' => $existingUser->id,
        'event_id' => $event->id,
        'status' => BookingStatus::Confirmed,
        'amount' => $event->price,
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/bookings', ['event_id' => $event->id])
        ->assertSessionHasErrors('event');
});

it('creates draft booking and waits for webhook confirmation', function () {
    $event = Event::factory()->create(['capacity' => 10]);
    $user = User::factory()->create();

    Http::fake([
        'https://securepay.tinkoff.ru/v2/Init' => Http::response([
            'Success' => true,
            'PaymentId' => 'payment_test_1',
            'PaymentURL' => 'https://pay.test/redirect',
        ], 200),
    ]);

    $this->actingAs($user)
        ->post('/bookings', ['event_id' => $event->id])
        ->assertRedirect('https://pay.test/redirect');

    expect(Booking::query()->where('user_id', $user->id)->where('event_id', $event->id)->first()->status)
        ->toBe(BookingStatus::Draft);

    $this->postJson('/api/webhooks/tbank', ['PaymentId' => 'payment_test_1', 'Status' => 'CONFIRMED'])
        ->assertOk();

    expect(Booking::query()->where('user_id', $user->id)->where('event_id', $event->id)->first()->status)
        ->toBe(BookingStatus::Confirmed);
});
