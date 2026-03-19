<?php

namespace App\Jobs;

use App\Services\Email\EmailNotificationService;
use App\Services\Telegram\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendUserNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $userId, public string $type, public array $payload = []) {}

    public function handle(EmailNotificationService $email, TelegramService $telegram): void
    {
        $email->send($this->userId, $this->type, $this->payload);
        $telegram->send($this->userId, $this->type, $this->payload);
    }
}
