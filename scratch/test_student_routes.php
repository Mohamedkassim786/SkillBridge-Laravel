<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\User::where('email', 'student@skillbridge.com')->first();
Illuminate\Support\Facades\Auth::login($student);

$routes = [
    'student.dashboard' => route('student.dashboard'),
    'student.courses.index' => route('student.courses.index'),
    'student.live-classroom' => route('student.live-classroom'),
    'student.certificates.index' => route('student.certificates.index'),
    'student.applications.index' => route('student.applications.index'),
    'student.payments.index' => route('student.payments.index'),
    'student.settings.index' => route('student.settings.index'),
];

foreach ($routes as $name => $url) {
    echo "Testing route [{$name}] -> {$url}: ";
    try {
        $response = $kernel->handle(
            $request = Illuminate\Http\Request::create($url, 'GET')
        );
        echo "HTTP " . $response->getStatusCode() . "\n";
    } catch (\Throwable $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}
