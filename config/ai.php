<?php

return [
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'gemini'),

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY', null),
        'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY', null),
        'model' => env('OPENAI_MODEL', 'gpt-4o'),
    ],
];
