<?php

namespace App\Domain\Student\Services;

use App\Models\Enrollment;
use App\Models\LessonProgress;

class CourseProgressService
{
    public function recalculateCourseProgress(string $userId, string $courseId, int $completedLessons, int $totalLessons): int
    {
        $percentage = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;
        $percentage = min(100, max(0, $percentage));

        Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->update([
                'progress_percent' => $percentage,
                'status' => $percentage >= 100 ? 'completed' : 'active',
                'completed_at' => $percentage >= 100 ? now() : null,
            ]);

        if ($percentage >= 100) {
            $enrollment = Enrollment::where('user_id', $userId)->where('course_id', $courseId)->first();
            if ($enrollment && $enrollment->course_version_id) {
                $uuid = (string) \Illuminate\Support\Str::uuid();
                \App\Models\Certificate::firstOrCreate(
                    ['user_id' => $userId, 'course_version_id' => $enrollment->course_version_id],
                    [
                        'uuid' => $uuid,
                        'certificate_hash' => hash('sha256', $userId . '-' . $courseId . '-' . time()),
                        'pdf_s3_key' => 'certificates/' . $userId . '_' . $courseId . '.pdf',
                        'issued_at' => now(),
                    ]
                );
            }
        }

        return $percentage;
    }
}
