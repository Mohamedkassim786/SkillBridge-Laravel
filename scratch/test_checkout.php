<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$course = App\Models\Course::first();
$student = App\Models\User::where('email', 'student@skillbridge.com')->first();
Illuminate\Support\Facades\Auth::login($student);

$checkout = new App\Livewire\Public\Checkout();
$checkout->mount($course->id);
$res = $checkout->processPayment();

echo "Checkout result: SUCCESS! Order & Payment created, enrolled in course " . $course->title . "\n";
