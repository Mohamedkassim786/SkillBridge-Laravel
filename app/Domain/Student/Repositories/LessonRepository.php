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
        // First lesson in module is unlocked by default
        $module = $lesson->module;
        if (! $module) {
            return true;
        }

        $previousLesson = Lesson::where('module_id', $module->id)
            ->where('sort_order', '<', $lesson->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if (! $previousLesson) {
            return true;
        }

        $prevProgress = LessonProgress::where('user_id', $user->id)
            ->where('lesson_id', $previousLesson->id)
            ->first();

        return ($prevProgress?->watch_percentage ?? 0) >= 90;
    }
}
