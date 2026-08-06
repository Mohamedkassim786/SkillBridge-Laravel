<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\User::where('email', 'student@skillbridge.com')->first();
Illuminate\Support\Facades\Auth::login($student);

$req = Illuminate\Http\Request::create('/student/dashboard', 'GET');
$req->setLaravelSession($app['session']->driver());
$res = $app->handle($req);

echo "Sidebar Render Status: HTTP " . $res->getStatusCode() . "\n";
