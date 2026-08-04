<?php

namespace App\Domain\Student\Services;

use App\Domain\Courses\Services\LessonProgressService;
use App\Models\Lesson;
use App\Models\User;

class LessonCompletionService
{
    public function __construct(
        protected LessonProgressService $progressService,
        protected CourseProgressService $courseProgressService
    ) {}

    public function recordProgress(User $user, Lesson $lesson, int $watchTimeSeconds, int $durationSeconds): bool
    {
        $percentage = min(100, (int) round(($watchTimeSeconds / max(1, $durationSeconds)) * 100));

        $this->progressService->bufferProgress($user->id, $lesson->id, $watchTimeSeconds, $durationSeconds);
        $this->progressService->syncBufferedProgressToDatabase($user->id, $lesson->id);

        return $percentage >= 90;
    }
}
