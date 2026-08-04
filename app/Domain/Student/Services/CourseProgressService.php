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

        return $percentage;
    }
}
