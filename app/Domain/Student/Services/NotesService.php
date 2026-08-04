<?php

namespace App\Domain\Student\Services;

use App\Domain\Student\Contracts\LessonNotesRepositoryInterface;
use App\Models\LessonNote;
use App\Models\User;

class NotesService
{
    public function __construct(
        protected LessonNotesRepositoryInterface $notesRepository
    ) {}

    public function addNote(User $user, string $lessonId, int $timestampSeconds, string $text): LessonNote
    {
        return $this->notesRepository->createNote($user, $lessonId, $timestampSeconds, $text);
    }

    public function removeNote(User $user, string $noteId): bool
    {
        return $this->notesRepository->deleteNote($user, $noteId);
    }
}
