<?php

namespace App\Jobs;

use App\Models\Enrollment;
use App\Models\LiveClass;
use App\Notifications\LiveClassReminderNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class UpdateClassStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $now = Carbon::now();

        // 1. Transition 'scheduled' to 'starting_soon' (within 10 minutes)
        $startingSoonClasses = LiveClass::where('status', 'scheduled')
            ->where('start_at', '<=', $now->copy()->addMinutes(10))
            ->where('start_at', '>', $now)
            ->get();

        foreach ($startingSoonClasses as $lc) {
            $lc->update(['status' => 'starting_soon']);

            // Send 10m reminder notification
            $students = Enrollment::where('course_id', $lc->course_id)
                ->when($lc->batch_id, fn($q) => $q->where('cohort_id', $lc->batch_id))
                ->where('status', 'active')
                ->with('user')
                ->get()
                ->pluck('user')
                ->filter();

            if ($students->isNotEmpty()) {
                Notification::send($students, new LiveClassReminderNotification($lc, '10m'));
            }
        }

        // 2. Transition 'starting_soon' or 'scheduled' to 'live' when start_at reached
        LiveClass::whereIn('status', ['scheduled', 'starting_soon'])
            ->where('start_at', '<=', $now)
            ->where('end_at', '>', $now)
            ->update(['status' => 'live']);

        // 3. Transition 'live' or 'starting_soon' to 'completed' when end_at passed
        LiveClass::whereIn('status', ['scheduled', 'starting_soon', 'live'])
            ->where('end_at', '<=', $now)
            ->update(['status' => 'completed']);
    }
}
