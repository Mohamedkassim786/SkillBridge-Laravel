<?php

namespace App\Domain\Student\Services;

use App\Domain\Student\Contracts\LessonBookmarkRepositoryInterface;
use App\Models\LessonBookmark;
use App\Models\User;

class BookmarkService
{
    public function __construct(
        protected LessonBookmarkRepositoryInterface $bookmarkRepository
    ) {}

    public function toggleBookmark(User $user, string $lessonId, int $timestampSeconds, ?string $title = null): LessonBookmark
    {
        return $this->bookmarkRepository->createBookmark($user, $lessonId, $timestampSeconds, $title);
    }

    public function removeBookmark(User $user, string $bookmarkId): bool
    {
        return $this->bookmarkRepository->deleteBookmark($user, $bookmarkId);
    }
}
