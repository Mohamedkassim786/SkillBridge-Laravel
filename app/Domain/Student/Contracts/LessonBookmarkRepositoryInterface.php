<?php

namespace App\Domain\Student\Contracts;

use App\Models\LessonBookmark;
use App\Models\User;
use Illuminate\Support\Collection;

interface LessonBookmarkRepositoryInterface
{
    public function getBookmarksForLesson(User $user, string $lessonId): Collection;

    public function searchBookmarks(User $user, string $query): Collection;

    public function createBookmark(User $user, string $lessonId, int $timestampSeconds, ?string $title = null): LessonBookmark;

    public function deleteBookmark(User $user, string $bookmarkId): bool;
}
