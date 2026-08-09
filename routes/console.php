<?php

use App\Jobs\PruneStaleAttendanceJob;
use App\Jobs\UpdateClassStatusJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Live Class Status Auto-Scheduler & Stale Attendance Pruning
Schedule::job(new UpdateClassStatusJob)->everyMinute();
Schedule::job(new PruneStaleAttendanceJob)->everyFifteenMinutes();
