<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\LessonBookmarkRepositoryInterface;
use App\Models\LessonBookmark;
use App\Models\User;
use Illuminate\Support\Collection;

class LessonBookmarkRepository implements LessonBookmarkRepositoryInterface
{
    public function getBookmarksForLesson(User $user, string $lessonId): Collection
    {
        return LessonBookmark::with('lesson.module.courseVersion.course')
            ->where('user_id', $user->id)
            ->where('lesson_id', $lessonId)
            ->orderBy('timestamp_seconds', 'asc')
            ->get();
    }

    public function searchBookmarks(User $user, string $query): Collection
    {
        return LessonBookmark::with('lesson.module.courseVersion.course')
            ->where('user_id', $user->id)
            ->where('title', 'LIKE', '%'.$query.'%')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createBookmark(User $user, string $lessonId, int $timestampSeconds, ?string $title = null): LessonBookmark
    {
        return LessonBookmark::create([
            'user_id' => $user->id,
            'lesson_id' => $lessonId,
            'timestamp_seconds' => $timestampSeconds,
            'title' => $title ?: 'Bookmark at '.gmdate('H:i:s', $timestampSeconds),
        ]);
    }

    public function deleteBookmark(User $user, string $bookmarkId): bool
    {
        return (bool) LessonBookmark::where('id', $bookmarkId)->where('user_id', $user->id)->delete();
    }
}
