<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\LessonRepositoryInterface;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;

class LessonRepository implements LessonRepositoryInterface
{
    public function findById(string $lessonId): ?Lesson
    {
        return Lesson::with('module.courseVersion.course')->find($lessonId);
    }

    public function getLessonProgress(User $user, string $lessonId): array
    {
        $progress = LessonProgress::where('user_id', $user->id)
            ->where('lesson_id', $lessonId)
            ->first();

        return [
            'watch_time_seconds' => $progress?->watch_time_seconds ?? 0,
            'watch_percentage' => $progress?->watch_percentage ?? 0,
            'is_completed' => (bool) ($progress?->is_completed ?? false),
        ];
    }

    public function isLessonUnlocked(User $user, Lesson $lesson): bool
    {
        // Free preview lessons are always unlocked
        if ($lesson->is_free_preview) {
            return true;
        }

        // Enrolled students have full access to all lessons in the course curriculum
        $courseId = $lesson->module?->courseVersion?->course_id;
        if ($courseId) {
            $isEnrolled = \App\Models\Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->exists();

            if ($isEnrolled) {
                return true;
            }
        }

        return true;
    }
}
