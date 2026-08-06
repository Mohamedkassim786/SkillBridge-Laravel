<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$courses = App\Models\Course::all();

foreach ($courses as $c) {
    echo "Course [{$c->title}] => Thumbnail URL: {$c->thumbnail}\n";
}
