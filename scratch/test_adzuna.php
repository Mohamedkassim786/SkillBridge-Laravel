<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$res = Illuminate\Support\Facades\Http::get('https://api.adzuna.com/v1/api/jobs/in/search/1', [
    'app_id' => 'b1cb7505',
    'app_key' => 'ffebba9d13743714202cd9eacffdff94',
    'results_per_page' => 5,
    'what' => 'developer',
]);

echo "Status: " . $res->status() . "\n";
$results = $res->json('results', []);
echo "Found " . count($results) . " jobs.\n";
if (!empty($results)) {
    echo "First Job: " . $results[0]['title'] . " at " . ($results[0]['company']['display_name'] ?? 'Unknown') . "\n";
} else {
    echo "Body: " . $res->body() . "\n";
}
