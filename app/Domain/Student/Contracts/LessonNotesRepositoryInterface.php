<?php

namespace App\Domain\Student\Contracts;

use App\Models\LessonNote;
use App\Models\User;
use Illuminate\Support\Collection;

interface LessonNotesRepositoryInterface
{
    public function getNotesForLesson(User $user, string $lessonId): Collection;

    public function searchNotes(User $user, string $query): Collection;

    public function createNote(User $user, string $lessonId, int $timestampSeconds, string $noteText): LessonNote;

    public function updateNote(User $user, string $noteId, string $noteText): LessonNote;

    public function deleteNote(User $user, string $noteId): bool;
}
