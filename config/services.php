<?php

return [
    'postmark' => ['key' => env('POSTMARK_API_KEY')],
    'resend' => ['key' => env('RESEND_API_KEY')],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'slack' => ['notifications' => ['bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL')]],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'tbank' => [
        'base_url' => env('TBANK_BASE_URL', 'https://securepay.tinkoff.ru/v2'),
        'terminal_key' => env('TBANK_TERMINAL_KEY'),
        'password' => env('TBANK_PASSWORD'),
        'notification_url' => env('TBANK_NOTIFICATION_URL'),
    ],
];
