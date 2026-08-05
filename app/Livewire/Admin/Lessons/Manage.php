<?php

namespace App\Livewire\Admin\Lessons;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.student')]
#[Title('Admin - Video & Lesson Management')]
class Manage extends Component
{
    use WithFileUploads;

    public ?string $selectedCourseId = null;

    // Form inputs for creating/editing lesson
    public ?string $editingLessonId = null;
    public string $title = '';
    public ?string $module_id = null;
    public int $duration = 300;
    public bool $is_free_preview = true;
    public string $video_url = '';
    public $videoFile = null;

    public bool $showModal = false;

    public function mount()
    {
        // Check if user is admin or super_admin
        $user = auth()->user();
        if (! $user || ! in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access to Admin Video Management.');
        }

        $firstCourse = Course::first();
        if ($firstCourse) {
            $this->selectedCourseId = $firstCourse->id;
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editLesson(string $lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            return;
        }

        $this->editingLessonId = $lesson->id;
        $this->title = $lesson->title;
        $this->module_id = $lesson->module_id;
        $this->duration = $lesson->duration;
        $this->is_free_preview = (bool) $lesson->is_free_preview;
        $this->video_url = $lesson->video_url ?? '';
        $this->videoFile = null;

        $this->showModal = true;
    }

    public function saveLesson()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'duration' => 'required|integer|min:1',
            'is_free_preview' => 'boolean',
            'video_url' => 'nullable|string|max:500',
            'videoFile' => 'nullable|file|mimes:mp4,mp3,webm,ogg,wav,m4a,mov|max:102400', // max 100MB
        ]);

        $finalVideoUrl = $this->video_url;

        if ($this->videoFile) {
            $courseSlug = $this->selectedCourse?->slug ?? 'course-videos';
            $moduleObj = Module::find($this->module_id);
            $moduleSlug = $moduleObj ? \Illuminate\Support\Str::slug($moduleObj->title) : 'module-' . $this->module_id;

            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $this->videoFile->getClientOriginalName());
            $relFolder = "{$courseSlug}/{$moduleSlug}";
            $this->videoFile->storeAs("public/videos/{$relFolder}", $filename);
            $finalVideoUrl = "storage/videos/{$relFolder}/{$filename}";
        }

        if ($this->editingLessonId) {
            $lesson = Lesson::findOrFail($this->editingLessonId);
            $lesson->update([
                'title' => $this->title,
                'module_id' => $this->module_id,
                'duration' => $this->duration,
                'is_free_preview' => $this->is_free_preview,
                'video_url' => $finalVideoUrl ?: $lesson->video_url,
            ]);
            session()->flash('status', "Lesson '{$this->title}' updated successfully!");
        } else {
            $maxSortOrder = Lesson::where('module_id', $this->module_id)->max('sort_order') ?? 0;
            Lesson::create([
                'title' => $this->title,
                'module_id' => $this->module_id,
                'duration' => $this->duration,
                'is_free_preview' => $this->is_free_preview,
                'video_url' => $finalVideoUrl ?: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'sort_order' => $maxSortOrder + 1,
            ]);
            session()->flash('status', "New Lesson '{$this->title}' created successfully!");
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function deleteLesson(string $lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if ($lesson) {
            $title = $lesson->title;
            $lesson->delete();
            session()->flash('status', "Lesson '{$title}' deleted.");
        }
    }

    public function resetForm()
    {
        $this->editingLessonId = null;
        $this->title = '';
        $this->duration = 300;
        $this->is_free_preview = true;
        $this->video_url = '';
        $this->videoFile = null;

        $firstModule = $this->modules->first();
        if ($firstModule) {
            $this->module_id = $firstModule->id;
        }
    }

    public function getCoursesProperty()
    {
        return Course::all();
    }

    public function getSelectedCourseProperty()
    {
        return Course::find($this->selectedCourseId);
    }

    public function getModulesProperty()
    {
        if (! $this->selectedCourse) {
            return collect([]);
        }

        return $this->selectedCourse->currentVersion?->modules()->with('lessons')->get() ?? collect([]);
    }

    public function render()
    {
        return view('livewire.admin.lessons.manage', [
            'courses' => $this->courses,
            'selectedCourse' => $this->selectedCourse,
            'modules' => $this->modules,
        ]);
    }
}
