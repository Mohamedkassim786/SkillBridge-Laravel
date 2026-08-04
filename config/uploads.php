<?php

return [
    'disk' => env('FILESYSTEM_DISK', 'public'),

    'max_file_size' => [
        'video' => 512000, // 500 MB in KB
        'pdf' => 20480,    // 20 MB in KB
        'image' => 10240,   // 10 MB in KB
        'resume' => 10240,  // 10 MB in KB
    ],

    'allowed_mimes' => [
        'video' => ['video/mp4', 'video/webm', 'video/quicktime'],
        'pdf' => ['application/pdf'],
        'image' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
        'resume' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    ],
];
