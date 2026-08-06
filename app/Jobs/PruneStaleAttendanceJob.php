<?php

namespace App\Jobs;

use App\Models\LiveClassAttendee;
use App\Services\JitsiLiveClassService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PruneStaleAttendanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(JitsiLiveClassService $jitsiService): void
    {
        $cutoff = Carbon::now()->subMinutes(3);

        // Find active attendees whose last heartbeat ping was > 3 minutes ago
        $staleAttendees = LiveClassAttendee::with('liveClass')
            ->whereIn('attendance_status', ['joined'])
            ->where('last_seen_at', '<', $cutoff)
            ->get();

        foreach ($staleAttendees as $att) {
            if (! $att->joined_at) continue;

            $leftAt = $att->last_seen_at ?? $cutoff;
            $durationMins = max(1, (int) round($att->joined_at->diffInMinutes($leftAt)));
            $classDuration = $att->liveClass?->duration_minutes ?? 60;

            $att->update([
                'left_at' => $leftAt,
                'duration_minutes' => $durationMins,
                'attendance_status' => $jitsiService->calculateAttendanceStatus($durationMins, $classDuration),
            ]);
        }
    }
}
