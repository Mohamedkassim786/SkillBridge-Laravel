<?php

namespace App\Livewire\Student\Courses;

use App\Domain\Student\Contracts\CourseRepositoryInterface;
use App\Domain\Student\Contracts\LessonBookmarkRepositoryInterface;
use App\Domain\Student\Contracts\LessonNotesRepositoryInterface;
use App\Domain\Student\Contracts\LessonRepositoryInterface;
use App\Domain\Student\Services\BookmarkService;
use App\Domain\Student\Services\CourseProgressService;
use App\Domain\Student\Services\LearningAnalyticsService;
use App\Domain\Student\Services\LessonCompletionService;
use App\Domain\Student\Services\NotesService;
use App\Domain\Student\Services\ReviewService;
use App\Models\Course;
use App\Models\CourseResource;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Lesson Player - SkillBridge')]
class Player extends Component
{
    public Course $course;
    public ?Lesson $activeLesson = null;
    public string $activeTab = 'notes'; // notes, bookmarks, resources, reviews, analytics

    // Search filters for notes & bookmarks
    public string $noteSearch = '';
    public string $bookmarkSearch = '';

    // Editing Note state
    public ?string $editingNoteId = null;
    public string $editingNoteText = '';

    // Notes form inputs
    public string $newNoteText = '';
    public int $noteTimestamp = 0;

    // Review form inputs
    public int $reviewRating = 5;
    public string $reviewText = '';

    // Watch progress state
    public int $watchTimeSeconds = 0;
    public int $watchPercentage = 0;
    public bool $isCompleted = false;

    public function mount(string $courseId, ?string $lesson = null)
    {
        $user = auth()->user();
        $courseRepository = app(CourseRepositoryInterface::class);
        $lessonRepository = app(LessonRepositoryInterface::class);

        // Security Authorization: Student must be enrolled
        if (! $courseRepository->isEnrolled($user, $courseId)) {
            abort(403, 'Unauthorized access. You are not enrolled in this course.');
        }

        $found = $courseRepository->findWithDetails($courseId, $user);
        if (! $found) {
            abort(404, 'Course not found');
        }

        $this->course = $found;
        $this->authorize('view', $this->course);

        if ($lesson) {
            $this->activeLesson = $lessonRepository->findById($lesson);
        }

        if (! $this->activeLesson) {
            $firstModule = $this->course->currentVersion?->modules?->first();
            $this->activeLesson = $firstModule?->lessons?->first();
        }

        if ($this->activeLesson && ! $lessonRepository->isLessonUnlocked($user, $this->activeLesson)) {
            session()->flash('warning', 'That lesson is locked. Complete previous lessons to unlock.');
            $firstModule = $this->course->currentVersion?->modules?->first();
            $this->activeLesson = $firstModule?->lessons?->first();
        }

        $this->loadLessonProgress($lessonRepository);
    }

    public function loadLessonProgress(LessonRepositoryInterface $lessonRepository)
    {
        if ($this->activeLesson) {
            $progressData = $lessonRepository->getLessonProgress(auth()->user(), $this->activeLesson->id);
            $this->watchTimeSeconds = $progressData['watch_time_seconds'];
            $this->watchPercentage = $progressData['watch_percentage'];
            $this->isCompleted = $progressData['is_completed'];
        }
    }

    public function selectLesson(string $lessonId)
    {
        $lessonRepository = app(LessonRepositoryInterface::class);
        $lesson = $lessonRepository->findById($lessonId);
        if (! $lesson) {
            return;
        }

        if (! $lessonRepository->isLessonUnlocked(auth()->user(), $lesson)) {
            session()->flash('warning', 'Lesson 🔒 is locked. Complete the previous lesson to unlock.');

            return;
        }

        $this->activeLesson = $lesson;
        $this->loadLessonProgress($lessonRepository);
    }

    public function markAsComplete()
    {
        if (! $this->activeLesson) {
            return;
        }

        $user = auth()->user();
        $duration = max(1, $this->activeLesson->duration);

        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $this->activeLesson->id],
            [
                'watch_time_seconds' => $duration,
                'watch_percentage' => 100,
                'is_completed' => true,
            ]
        );

        $this->isCompleted = true;
        $this->watchPercentage = 100;

        $allLessons = $this->course->currentVersion?->modules?->pluck('lessons')->flatten() ?? collect([]);
        $totalLessons = $allLessons->count();
        $completedCount = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $progressService = app(CourseProgressService::class);
        $progressService->recalculateCourseProgress($user->id, $this->course->id, $completedCount, $totalLessons);

        session()->flash('status', 'Lesson marked as complete! Next lesson unlocked 🎉');
    }

    public function addNote()
    {
        $this->validate([
            'newNoteText' => 'required|string|min:3|max:1000',
        ]);

        if ($this->activeLesson) {
            $notesService = app(NotesService::class);
            $notesService->addNote(auth()->user(), $this->activeLesson->id, $this->noteTimestamp, $this->newNoteText);
            $this->newNoteText = '';
            session()->flash('status', 'Note saved at current timestamp!');
        }
    }

    public function editNote(string $noteId, string $currentText)
    {
        $this->editingNoteId = $noteId;
        $this->editingNoteText = $currentText;
    }

    public function updateNote()
    {
        $this->validate([
            'editingNoteText' => 'required|string|min:3|max:1000',
        ]);

        if ($this->editingNoteId) {
            $notesRepo = app(LessonNotesRepositoryInterface::class);
            $notesRepo->updateNote(auth()->user(), $this->editingNoteId, $this->editingNoteText);
            $this->editingNoteId = null;
            $this->editingNoteText = '';
            session()->flash('status', 'Note updated successfully.');
        }
    }

    public function deleteNote(string $noteId)
    {
        $notesService = app(NotesService::class);
        $notesService->removeNote(auth()->user(), $noteId);
        session()->flash('status', 'Note deleted.');
    }

    public function toggleBookmark()
    {
        if ($this->activeLesson) {
            $bookmarkService = app(BookmarkService::class);
            $bookmarkService->toggleBookmark(auth()->user(), $this->activeLesson->id, $this->noteTimestamp);
            session()->flash('status', 'Bookmark added at timecode!');
        }
    }

    public function removeBookmark(string $bookmarkId)
    {
        $bookmarkService = app(BookmarkService::class);
        $bookmarkService->removeBookmark(auth()->user(), $bookmarkId);
        session()->flash('status', 'Bookmark removed.');
    }

    public function downloadResource(string $resourceId)
    {
        $res = CourseResource::where('course_id', $this->course->id)->find($resourceId);
        if ($res) {
            $res->increment('download_count');
            session()->flash('status', "Downloading resource '{$res->title}'...");
        }
    }

    public function submitReview()
    {
        $this->validate([
            'reviewText' => 'required|string|min:10',
            'reviewRating' => 'required|integer|between:1,5',
        ]);

        try {
            $reviewService = app(ReviewService::class);
            $reviewService->submitReview(auth()->user(), $this->course->id, $this->reviewRating, $this->reviewText);
            session()->flash('status', 'Course review submitted successfully!');
            $this->reviewText = '';
        } catch (\Exception $e) {
            session()->flash('warning', $e->getMessage());
        }
    }

    public function deleteReview(string $reviewId)
    {
        $reviewService = app(ReviewService::class);
        $reviewService->deleteReview(auth()->user(), $reviewId);
        session()->flash('status', 'Review deleted.');
    }

    public function getIsLocalMediaProperty(): bool
    {
        if (! $this->activeLesson || ! $this->activeLesson->video_url) {
            return false;
        }

        $url = strtolower($this->activeLesson->video_url);

        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be') || str_contains($url, 'vimeo.com')) {
            return false;
        }

        return str_starts_with($url, 'storage/') ||
               str_starts_with($url, 'videos/') ||
               str_contains($url, '/storage/') ||
               preg_match('/\.(mp4|mp3|webm|ogg|wav|m4a)$/i', $url) === 1;
    }

    public function getMediaUrlProperty(): string
    {
        if (! $this->activeLesson || ! $this->activeLesson->video_url) {
            return '';
        }

        $url = $this->activeLesson->video_url;

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        $cleanPath = ltrim(str_replace(['public/', 'storage/'], '', $url), '/');

        return route('media.stream', ['path' => $cleanPath]);
    }

    public function getEmbedUrlProperty(): string
    {
        if (! $this->activeLesson || ! $this->activeLesson->video_url) {
            return 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?enablejsapi=1&rel=0&modestbranding=1';
        }

        $url = $this->activeLesson->video_url;
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $url, $matches);
        $videoId = $matches[1] ?? 'dQw4w9WgXcQ';

        $startParam = $this->watchTimeSeconds > 0 ? "&start={$this->watchTimeSeconds}" : '';

        return "https://www.youtube-nocookie.com/embed/{$videoId}?enablejsapi=1&rel=0&modestbranding=1{$startParam}";
    }

    public function render(
        LessonNotesRepositoryInterface $notesRepo,
        LessonBookmarkRepositoryInterface $bookmarkRepo,
        CourseRepositoryInterface $courseRepo,
        LessonRepositoryInterface $lessonRepo,
        LearningAnalyticsService $analyticsService
    ) {
        $user = auth()->user();

        $notes = $this->noteSearch
            ? $notesRepo->searchNotes($user, $this->noteSearch)
            : ($this->activeLesson ? $notesRepo->getNotesForLesson($user, $this->activeLesson->id) : collect([]));

        $bookmarks = $this->bookmarkSearch
            ? $bookmarkRepo->searchBookmarks($user, $this->bookmarkSearch)
            : ($this->activeLesson ? $bookmarkRepo->getBookmarksForLesson($user, $this->activeLesson->id) : collect([]));

        $resources = $courseRepo->getCourseResources($this->course->id);
        $analytics = $analyticsService->getStudentAnalytics($user, $this->course);

        if ($this->course && $this->course->currentVersion) {
            $this->course->currentVersion->loadMissing(['modules.lessons']);
        }

        $modules = $this->course->currentVersion?->modules ?? collect([]);
        $allLessons = $modules->pluck('lessons')->flatten();

        $currentIndex = $allLessons->search(fn ($l) => (string) $l->id === (string) $this->activeLesson?->id);
        $previousLesson = ($currentIndex !== false && $currentIndex > 0) ? $allLessons->get($currentIndex - 1) : null;
        $nextLesson = ($currentIndex !== false && $currentIndex < $allLessons->count() - 1) ? $allLessons->get($currentIndex + 1) : null;

        $isNextUnlocked = $nextLesson ? $lessonRepo->isLessonUnlocked($user, $nextLesson) : false;

        return view('livewire.student.courses.player', [
            'notes' => $notes,
            'bookmarks' => $bookmarks,
            'resources' => $resources,
            'analytics' => $analytics,
            'modules' => $modules,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson,
            'isNextUnlocked' => $isNextUnlocked,
        ]);
    }
}
