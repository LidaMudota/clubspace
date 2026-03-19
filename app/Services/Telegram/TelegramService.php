<?php

namespace App\Services\Telegram;

use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function send(int $userId, string $type, array $payload = []): void
    {
        $user = User::query()->find($userId);
        $chatId = $user?->telegram_chat_id ?: config('clubspace.telegram.chat_id');
        $token = config('clubspace.telegram.bot_token');

        if (! $chatId || ! $token) {
            return;
        }

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => "Clubspace: {$type}",
        ]);

        NotificationLog::query()->create([
            'user_id' => $user?->id,
            'channel' => 'telegram',
            'type' => $type,
            'recipient' => (string) $chatId,
            'payload' => $payload,
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
