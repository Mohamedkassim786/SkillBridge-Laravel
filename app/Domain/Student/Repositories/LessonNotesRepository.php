<?php

namespace App\Domain\Student\Repositories;

use App\Domain\Student\Contracts\LessonNotesRepositoryInterface;
use App\Models\LessonNote;
use App\Models\User;
use Illuminate\Support\Collection;

class LessonNotesRepository implements LessonNotesRepositoryInterface
{
    public function getNotesForLesson(User $user, string $lessonId): Collection
    {
        return LessonNote::with('lesson.module.courseVersion.course')
            ->where('user_id', $user->id)
            ->where('lesson_id', $lessonId)
            ->orderBy('timestamp_seconds', 'asc')
            ->get();
    }

    public function searchNotes(User $user, string $query): Collection
    {
        return LessonNote::with('lesson.module.courseVersion.course')
            ->where('user_id', $user->id)
            ->where('note_text', 'LIKE', '%'.$query.'%')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createNote(User $user, string $lessonId, int $timestampSeconds, string $noteText): LessonNote
    {
        return LessonNote::create([
            'user_id' => $user->id,
            'lesson_id' => $lessonId,
            'timestamp_seconds' => $timestampSeconds,
            'note_text' => $noteText,
        ]);
    }

    public function updateNote(User $user, string $noteId, string $noteText): LessonNote
    {
        $note = LessonNote::where('id', $noteId)->where('user_id', $user->id)->firstOrFail();
        $note->update(['note_text' => $noteText]);

        return $note;
    }

    public function deleteNote(User $user, string $noteId): bool
    {
        return (bool) LessonNote::where('id', $noteId)->where('user_id', $user->id)->delete();
    }
}
