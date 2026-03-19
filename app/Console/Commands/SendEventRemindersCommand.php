<?php

namespace App\Console\Commands;

use App\Jobs\SendUserNotificationJob;
use App\Models\Booking;
use Illuminate\Console\Command;

class SendEventRemindersCommand extends Command
{
    protected $signature = 'clubspace:send-event-reminders';
    protected $description = 'Send event reminders';

    public function handle(): int
    {
        Booking::query()->where('status', 'confirmed')->whereHas('event', fn ($q) => $q->whereBetween('starts_at', [now(), now()->addDay()]))
            ->chunkById(100, function ($bookings): void {
                foreach ($bookings as $booking) {
                    SendUserNotificationJob::dispatch($booking->user_id, 'event_reminder', ['event_id' => $booking->event_id]);
                }
            });

        return self::SUCCESS;
    }
}
