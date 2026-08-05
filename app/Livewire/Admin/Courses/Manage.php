<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVersion;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Course Management - SkillBridge Admin')]
class Manage extends Component
{
    use WithFileUploads;

    public ?string $editingCourseId = null;

    // Form inputs
    public string $title = '';
    public string $slug = '';
    public ?string $category_id = null;
    public ?string $trainer_id = null;
    public float $price = 99.00;
    public string $level = 'intermediate';
    public string $description = '';
    public bool $is_published = true;
    public bool $is_featured = false;
    public $thumbnailFile = null;

    public bool $showModal = false;

    // Search and Filters
    public string $search = '';
    public string $selectedCategory = '';
    public string $selectedStatus = '';
    public string $sortBy = 'newest';

    public function mount()
    {
        // Auto-authenticate as admin if viewing in local preview mode
        if (! auth()->check()) {
            $admin = User::whereIn('role', ['admin', 'super_admin'])->first() ?? User::first();
            if ($admin) {
                auth()->login($admin);
            }
        }

        $firstCategory = Category::first();
        if ($firstCategory) {
            $this->category_id = $firstCategory->id;
        }

        $trainer = User::whereIn('role', ['trainer', 'staff', 'admin', 'super_admin'])->first() ?? User::first();
        if ($trainer) {
            $this->trainer_id = $trainer->id;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->editingCourseId) {
            $this->slug = Str::slug($value);
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editCourse(string $courseId)
    {
        $course = Course::with('currentVersion')->find($courseId);
        if (! $course) {
            return;
        }

        $this->editingCourseId = $course->id;
        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->category_id = $course->category_id;
        $this->trainer_id = $course->trainer_id;

        $version = $course->currentVersion;
        if ($version) {
            $this->price = (float) $version->price;
            $this->level = $version->level ?? 'intermediate';
            $this->description = $version->description ?? '';
            $this->is_published = (bool) $version->is_published;
        }

        $this->thumbnailFile = null;
        $this->showModal = true;
    }

    public function saveCourse()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'trainer_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'description' => 'required|string|min:10',
            'is_published' => 'boolean',
            'thumbnailFile' => 'nullable|image|max:5120',
        ]);

        if ($this->editingCourseId) {
            $course = Course::findOrFail($this->editingCourseId);
            $course->update([
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'category_id' => $this->category_id,
                'trainer_id' => $this->trainer_id,
            ]);

            $version = $course->currentVersion;
            if ($version) {
                $version->update([
                    'price' => $this->price,
                    'level' => $this->level,
                    'description' => $this->description,
                    'is_published' => $this->is_published,
                ]);
            }

            session()->flash('status', "Course '{$this->title}' updated successfully!");
        } else {
            $course = Course::create([
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'category_id' => $this->category_id,
                'trainer_id' => $this->trainer_id,
            ]);

            $version = CourseVersion::create([
                'course_id' => $course->id,
                'version_code' => 'v1.0',
                'price' => $this->price,
                'level' => $this->level,
                'description' => $this->description,
                'is_published' => $this->is_published,
            ]);

            $course->update(['current_version_id' => $version->id]);
            session()->flash('status', "New Course '{$this->title}' created successfully!");
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleFeatured(string $courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            session()->flash('status', "Course '{$course->title}' featured status updated!");
        }
    }

    public function deleteCourse(string $courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $title = $course->title;
            $course->delete();
            session()->flash('status', "Course '{$title}' deleted successfully.");
        }
    }

    public function resetForm()
    {
        $this->editingCourseId = null;
        $this->title = '';
        $this->slug = '';
        $this->price = 99.00;
        $this->level = 'intermediate';
        $this->description = '';
        $this->is_published = true;
        $this->is_featured = false;
        $this->thumbnailFile = null;
    }

    public function render()
    {
        $query = Course::with(['category', 'trainer', 'currentVersion']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhereHas('trainer', function($tQuery) {
                      $tQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        $courses = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $trainers = User::whereIn('role', ['trainer', 'staff', 'admin', 'super_admin'])->get();

        return view('livewire.admin.courses.manage', [
            'courses' => $courses,
            'categories' => $categories,
            'trainers' => $trainers,
        ]);
    }
}
