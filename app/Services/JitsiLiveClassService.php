<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\LiveClass;
use App\Models\LiveClassAttendee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class JitsiLiveClassService
{
    /**
     * Generate a cryptographically secure, unpredictable Jitsi room name.
     */
    public function generateRoomName(): string
    {
        return 'live_class_' . strtolower((string) Str::ulid()) . '_' . Str::random(8);
    }

    /**
     * Verify if a user is authorized to join the live class session.
     */
    public function canJoin(LiveClass $liveClass, User $user): bool
    {
        if ($liveClass->status === 'cancelled') {
            return false;
        }

        // Admins and Super Admins can join any class
        if ($user->hasRole(['admin', 'super_admin'])) {
            return true;
        }

        // Trainer who owns or creates the class
        if ($user->hasRole(['staff', 'trainer']) && ($liveClass->trainer_id === $user->id || $liveClass->created_by === $user->id)) {
            return true;
        }

        // Student authorization check: Must be enrolled in the course and assigned to the batch if batch is set
        if ($user->hasRole('student')) {
            $isEnrolled = $user->enrollments()
                ->where('course_id', $liveClass->course_id)
                ->where('status', 'active')
                ->when($liveClass->batch_id, function ($q) use ($liveClass) {
                    $q->where('cohort_id', $liveClass->batch_id);
                })
                ->exists();

            return $isEnrolled;
        }

        return false;
    }

    /**
     * Build authorized meeting options for frontend Jitsi embed.
     */
    public function getMeetingOptions(LiveClass $liveClass, User $user): array
    {
        $domain = config('services.jitsi.domain', 'meet.jit.si');
        $useJwt = config('services.jitsi.use_jwt', false);

        $options = [
            'domain' => $domain,
            'roomName' => $liveClass->room_name,
            'userInfo' => [
                'displayName' => $user->name,
                'email' => $user->email,
            ],
            'configOverwrite' => [
                'prejoinPageEnabled' => true,
                'disableDeepLinking' => true,
            ],
        ];

        if ($useJwt) {
            $options['jwt'] = $this->createJwtIfRequired($liveClass, $user);
        }

        return $options;
    }

    /**
     * Record or update student join event.
     */
    public function recordJoin(LiveClass $liveClass, User $user, ?string $ipAddress = null): LiveClassAttendee
    {
        $now = Carbon::now();

        $attendee = LiveClassAttendee::updateOrCreate(
            [
                'live_class_id' => $liveClass->id,
                'student_id' => $user->id,
            ],
            [
                'joined_at' => $now,
                'last_seen_at' => $now,
                'attendance_status' => 'joined',
                'ip_address' => $ipAddress,
            ]
        );

        $this->logMeetingActivity($liveClass, $user, 'joined_class');

        return $attendee;
    }

    /**
     * Update heartbeat timestamp and recalculate duration.
     */
    public function recordHeartbeat(LiveClass $liveClass, User $user): ?LiveClassAttendee
    {
        $now = Carbon::now();

        $attendee = LiveClassAttendee::where('live_class_id', $liveClass->id)
            ->where('student_id', $user->id)
            ->first();

        if (! $attendee) {
            return $this->recordJoin($liveClass, $user);
        }

        $joinedAt = $attendee->joined_at ?? $now;
        $durationMins = max(1, (int) round($joinedAt->diffInMinutes($now)));

        $attendee->update([
            'last_seen_at' => $now,
            'duration_minutes' => $durationMins,
            'attendance_status' => $this->calculateAttendanceStatus($durationMins, $liveClass->duration_minutes),
        ]);

        return $attendee;
    }

    /**
     * Record student leave event and update final duration & status.
     */
    public function recordLeave(LiveClass $liveClass, User $user): ?LiveClassAttendee
    {
        $now = Carbon::now();

        $attendee = LiveClassAttendee::where('live_class_id', $liveClass->id)
            ->where('student_id', $user->id)
            ->first();

        if (! $attendee) {
            return null;
        }

        $joinedAt = $attendee->joined_at ?? $now;
        $durationMins = max(1, (int) round($joinedAt->diffInMinutes($now)));

        $attendee->update([
            'left_at' => $now,
            'last_seen_at' => $now,
            'duration_minutes' => $durationMins,
            'attendance_status' => $this->calculateAttendanceStatus($durationMins, $liveClass->duration_minutes),
        ]);

        $this->logMeetingActivity($liveClass, $user, 'left_class', ['duration_minutes' => $durationMins]);

        return $attendee;
    }

    /**
     * Calculate attendance status based on duration rules.
     * Configurable rules:
     * - < 10 mins => absent
     * - >= 10 mins & < 50% class duration => partial
     * - >= 50% class duration => attended
     */
    public function calculateAttendanceStatus(int $userDurationMins, int $classDurationMins): string
    {
        if ($userDurationMins < 10) {
            return 'absent';
        }

        $halfDuration = max(10, (int) ceil($classDurationMins / 2));

        if ($userDurationMins >= $halfDuration) {
            return 'attended';
        }

        return 'partial';
    }

    /**
     * Create Jitsi JWT token if server requires token authentication.
     */
    public function createJwtIfRequired(LiveClass $liveClass, User $user): string
    {
        $appId = config('services.jitsi.app_id');
        $secret = config('services.jitsi.app_secret');

        if (empty($appId) || empty($secret)) {
            return '';
        }

        // Basic payload structure for Jitsi JWT
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = base64_encode(json_encode([
            'iss' => $appId,
            'sub' => config('services.jitsi.domain'),
            'aud' => 'jitsi',
            'room' => $liveClass->room_name,
            'exp' => time() + 3600 * 2,
            'context' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                ],
            ],
        ]));

        $signature = base64_encode(hash_hmac('sha256', "{$header}.{$payload}", $secret, true));

        return "{$header}.{$payload}.{$signature}";
    }

    /**
     * Log meeting activity to AuditLog table.
     */
    public function logMeetingActivity(LiveClass $liveClass, User $user, string $action, array $metadata = []): void
    {
        try {
            AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'auditable_type' => LiveClass::class,
                'auditable_id' => $liveClass->id,
                'new_values' => array_merge([
                    'room_name' => $liveClass->room_name,
                    'title' => $liveClass->title,
                ], $metadata),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Fail silently on log error
        }
    }
}
