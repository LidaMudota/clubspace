<?php

return [
    'auth' => [
        'otp_ttl_minutes' => env('OTP_TTL_MINUTES', 10),
    ],
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'chat_id' => env('TELEGRAM_CHAT_ID'),
    ],
];
