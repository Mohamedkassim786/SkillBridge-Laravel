<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rolesTest = [
    ['email' => 'superadmin@skillbridge.com', 'route' => '/super-admin/dashboard', 'role' => 'Super Admin'],
    ['email' => 'admin@skillbridge.com', 'route' => '/admin/dashboard', 'role' => 'Admin'],
    ['email' => 'staff@skillbridge.com', 'route' => '/staff/dashboard', 'role' => 'Staff / Trainer'],
    ['email' => 'student@skillbridge.com', 'route' => '/student/dashboard', 'role' => 'Student'],
];

echo "=== TESTING ALL 4 LOGIN ROLES ===\n\n";

foreach ($rolesTest as $test) {
    $user = App\Models\User::where('email', $test['email'])->first();
    if ($user) {
        Illuminate\Support\Facades\Auth::login($user);
        $req = Illuminate\Http\Request::create($test['route'], 'GET');
        $req->setLaravelSession($app['session']->driver());
        $res = $app->handle($req);
        echo "[ROLE: {$test['role']}] User: {$user->email} => GET {$test['route']} => HTTP " . $res->getStatusCode() . "\n";
    } else {
        echo "[ROLE: {$test['role']}] User {$test['email']} NOT FOUND\n";
    }
}

// Guest Public Test
$reqPublic = Illuminate\Http\Request::create('/', 'GET');
$reqPublic->setLaravelSession($app['session']->driver());
$resPublic = $app->handle($reqPublic);
echo "[ROLE: Guest Public] => GET / => HTTP " . $resPublic->getStatusCode() . "\n";
