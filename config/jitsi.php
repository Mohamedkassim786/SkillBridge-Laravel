<?php

return [
    'domain' => env('JITSI_DOMAIN', 'meet.jit.si'),
    'use_jwt' => (bool) env('JITSI_USE_JWT', false),
    'app_id' => env('JITSI_APP_ID', ''),
    'app_secret' => env('JITSI_APP_SECRET', ''),
    'token_ttl' => (int) env('JITSI_TOKEN_TTL', 3600),
    'room_prefix' => env('JITSI_ROOM_PREFIX', 'live_class_'),
];
