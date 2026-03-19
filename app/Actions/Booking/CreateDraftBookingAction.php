<?php

namespace App\Actions\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CreateDraftBookingAction
{
    public function execute(User $user, Event $event): Booking
    {
        if ($event->availableSeats() <= 0) {
            throw ValidationException::withMessages(['event' => 'Свободные места закончились.']);
        }

        return Booking::query()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => BookingStatus::Draft,
            'amount' => $event->price,
        ]);
    }
}
