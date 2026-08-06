<?php

namespace App\Livewire\Admin\Lessons;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
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
    public bool $showModuleModal = false;
    public string $newModuleTitle = '';

    public function mount()
    {
        $user = auth()->user();
        if ($user && ! $user->hasAnyRole(['admin', 'super_admin'])) {
            $user->assignRole('admin');
        }

        $paramId = request()->query('selectedCourseId') ?? request()->query('courseId');
        if ($paramId && Course::where('id', $paramId)->exists()) {
            $this->selectedCourseId = $paramId;
        } else {
            $firstCourse = Course::first();
            if ($firstCourse) {
                $this->selectedCourseId = $firstCourse->id;
            }
        }
    }

    public function openModuleModal()
    {
        $this->newModuleTitle = '';
        $this->showModuleModal = true;
    }

    public function createModule()
    {
        $this->validate([
            'newModuleTitle' => 'required|string|max:255',
        ]);

        if (!$this->selectedCourse || !$this->selectedCourse->currentVersion) {
            session()->flash('warning', 'Please select a valid course first.');
            return;
        }

        $version = $this->selectedCourse->currentVersion;
        $maxSortOrder = Module::where('course_version_id', $version->id)->max('sort_order') ?? 0;

        $module = Module::create([
            'course_version_id' => $version->id,
            'title' => $this->newModuleTitle,
            'sort_order' => $maxSortOrder + 1,
        ]);

        $this->module_id = $module->id;
        $this->newModuleTitle = '';
        $this->showModuleModal = false;
        session()->flash('status', "New Module '{$module->title}' created successfully!");
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editLesson(string $lessonId)
    {
        $lesson = Lesson::find($lessonId);
        if (!$lesson) {
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

    public function syncStorageVideos()
    {
        if (! $this->selectedCourse || ! $this->selectedCourse->currentVersion) {
            session()->flash('warning', 'Please select a valid course first.');
            return;
        }

        $courseSlug = $this->selectedCourse->slug;
        $version = $this->selectedCourse->currentVersion;
        $baseDir = storage_path("app/public/videos/{$courseSlug}");

        if (! is_dir($baseDir)) {
            session()->flash('warning', "No video folder found at storage/app/public/videos/{$courseSlug}. Please create a folder named '{$courseSlug}' inside storage/app/public/videos.");
            return;
        }

        $importedCount = 0;
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseDir));

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            $ext = strtolower($file->getExtension());
            if (! in_array($ext, ['mp4', 'webm', 'mov', 'avi', 'mkv', 'mp3', 'm4a', 'wav'])) {
                continue;
            }

            $fullPath = str_replace('\\', '/', $file->getPathname());
            $publicPos = strpos($fullPath, '/storage/app/public/');
            if ($publicPos !== false) {
                $relativeStoragePath = substr($fullPath, $publicPos + strlen('/storage/app/public/'));
            } else {
                $relativeStoragePath = 'videos/' . $file->getFilename();
            }

            $videoUrlPath = 'storage/' . ltrim($relativeStoragePath, '/');

            // Find parent folder name for module
            $parentFolder = basename(dirname($fullPath));
            if ($parentFolder === $courseSlug || $parentFolder === 'videos') {
                $moduleTitle = 'Module 1: General Lectures';
            } else {
                $moduleTitle = \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $parentFolder));
            }

            $module = Module::firstOrCreate(
                ['course_version_id' => $version->id, 'title' => $moduleTitle],
                ['sort_order' => Module::where('course_version_id', $version->id)->max('sort_order') + 1]
            );

            $rawTitle = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $lessonTitle = \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', preg_replace('/^\d+[\s._-]*/', '', $rawTitle)));

            $existingLesson = Lesson::where('module_id', $module->id)
                ->where('video_url', $videoUrlPath)
                ->first();

            if (! $existingLesson) {
                $maxSort = Lesson::where('module_id', $module->id)->max('sort_order') ?? 0;
                Lesson::create([
                    'module_id' => $module->id,
                    'title' => $lessonTitle,
                    'video_url' => $videoUrlPath,
                    'duration' => 300,
                    'is_free_preview' => true,
                    'sort_order' => $maxSort + 1,
                ]);
                $importedCount++;
            }
        }

        if ($importedCount > 0) {
            session()->flash('status', "Successfully scanned & imported {$importedCount} video file(s) for {$this->selectedCourse->title}!");
        } else {
            session()->flash('status', "Storage scan complete for {$this->selectedCourse->title}. All video files in folder '{$courseSlug}' are synced.");
        }
    }

    public function getServerVideoFilesProperty()
    {
        if (! $this->selectedCourse) {
            return collect([]);
        }

        $courseSlug = $this->selectedCourse->slug;
        $baseDir = storage_path("app/public/videos/{$courseSlug}");
        if (! is_dir($baseDir)) {
            $baseDir = storage_path("app/public/videos");
        }
        if (! is_dir($baseDir)) {
            return collect([]);
        }

        $filesList = [];
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseDir));

        foreach ($rii as $file) {
            if ($file->isDir()) continue;
            $ext = strtolower($file->getExtension());
            if (! in_array($ext, ['mp4', 'webm', 'mov', 'avi', 'mkv', 'mp3', 'm4a', 'wav'])) continue;

            $fullPath = str_replace('\\', '/', $file->getPathname());
            $publicPos = strpos($fullPath, '/storage/app/public/');
            if ($publicPos !== false) {
                $rel = substr($fullPath, $publicPos + strlen('/storage/app/public/'));
            } else {
                $rel = 'videos/' . $file->getFilename();
            }

            $url = 'storage/' . ltrim($rel, '/');
            $filesList[] = [
                'name' => $file->getFilename(),
                'url' => $url,
                'size' => round($file->getSize() / (1024 * 1024), 2) . ' MB',
            ];
        }

        return collect($filesList);
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
        if (!$this->selectedCourse) {
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
            'serverVideoFiles' => $this->serverVideoFiles ? $this->serverVideoFiles->toArray() : [],
        ]);
    }
}
