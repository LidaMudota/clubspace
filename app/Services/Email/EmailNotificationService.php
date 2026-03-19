<?php

namespace App\Services\Email;

use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    public function send(int $userId, string $type, array $payload = []): void
    {
        $user = User::query()->find($userId);
        if (! $user?->email) {
            return;
        }

        Mail::raw("Clubspace: {$type}", function ($message) use ($user) {
            $message->to($user->email)->subject('Clubspace уведомление');
        });

        NotificationLog::query()->create([
            'user_id' => $user->id,
            'channel' => 'mail',
            'type' => $type,
            'recipient' => $user->email,
            'payload' => $payload,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
