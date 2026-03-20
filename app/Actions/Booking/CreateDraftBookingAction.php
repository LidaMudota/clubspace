<?php

namespace App\Actions\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateDraftBookingAction
{
    public function execute(User $user, Event $event): Booking
    {
        return DB::transaction(function () use ($user, $event) {
            $lockedEvent = Event::query()->lockForUpdate()->findOrFail($event->id);

            $existingBooking = Booking::query()
                ->where('user_id', $user->id)
                ->where('event_id', $lockedEvent->id)
                ->whereIn('status', [BookingStatus::Draft, BookingStatus::Confirmed])
                ->latest('id')
                ->first();

            if ($existingBooking) {
                return $existingBooking;
            }

            if ($lockedEvent->availableSeats() <= 0) {
                throw ValidationException::withMessages(['event' => 'Свободные места закончились.']);
            }

            return Booking::query()->create([
                'user_id' => $user->id,
                'event_id' => $lockedEvent->id,
                'status' => BookingStatus::Draft,
                'amount' => $lockedEvent->price,
            ]);
        });
    }
}
