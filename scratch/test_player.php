<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$course = App\Models\Course::first();
$student = App\Models\User::where('email', 'student@skillbridge.com')->first();
Illuminate\Support\Facades\Auth::login($student);

$player = new App\Livewire\Student\Courses\Player();
$player->mount($course->id);

echo "Player Mounted Successfully! Active Lesson: " . ($player->activeLesson?->title ?? 'None') . "\n";
