<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\User::where('email', 'student@skillbridge.com')->first();
Illuminate\Support\Facades\Auth::login($student);

$routes = [
    '/student/dashboard',
    '/student/courses',
    '/student/live-classroom',
    '/student/certificates',
    '/student/applications',
    '/student/payments',
    '/student/settings',
];

foreach ($routes as $path) {
    $req = Illuminate\Http\Request::create($path, 'GET');
    $req->setLaravelSession($app['session']->driver());
    $res = $app->handle($req);
    echo "Authenticated GET {$path} => HTTP " . $res->getStatusCode() . "\n";
}
