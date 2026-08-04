<?php

namespace App\Domain\Student\Contracts;

use App\Models\Lesson;
use App\Models\User;

interface LessonRepositoryInterface
{
    public function findById(string $lessonId): ?Lesson;

    public function getLessonProgress(User $user, string $lessonId): array;

    public function isLessonUnlocked(User $user, Lesson $lesson): bool;
}
