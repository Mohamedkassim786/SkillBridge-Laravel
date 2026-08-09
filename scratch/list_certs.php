<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Certificate::with('user')->get() as $c) {
    echo "ID: {$c->id} | UUID: {$c->uuid} | User: " . ($c->user?->name ?? 'N/A') . "\n";
}
