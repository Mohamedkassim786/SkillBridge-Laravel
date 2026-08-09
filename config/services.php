<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'jitsi' => [
        'domain' => env('JITSI_DOMAIN', 'meet.jit.si'),
        'use_jwt' => env('JITSI_USE_JWT', false),
        'app_id' => env('JITSI_APP_ID', ''),
        'app_secret' => env('JITSI_APP_SECRET', ''),
    ],

    'nvidia' => [
        'api_key' => env('NVIDIA_API_KEY'),
        'base_url' => env('NVIDIA_BASE_URL', 'https://integrate.api.nvidia.com/v1'),
        'llm_model' => env('NVIDIA_LLM_MODEL', 'meta/llama-3.3-70b-instruct'),
        'asr_model' => env('NVIDIA_ASR_MODEL', 'nvidia/parakeet-ctc-1.1b'),
        'tts_model' => env('NVIDIA_TTS_MODEL', 'nvidia/magpie-tts'),
        'tts_voice' => env('NVIDIA_TTS_VOICE', 'Magpie-Multilingual.EN-US.Aria'),
    ],

];
