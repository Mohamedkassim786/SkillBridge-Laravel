<?php

namespace App\Livewire\Public\Courses;

use App\Models\Category;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
#[Title('Explore Our Courses - SkillBridge')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category_id = '';
    public string $level = '';
    public string $sort = 'popular';
    public string $price_range = '10000';
    public string $rating_filter = '';
    public string $duration_filter = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedCategoryId() { $this->resetPage(); }
    public function updatedLevel() { $this->resetPage(); }
    public function updatedSort() { $this->resetPage(); }
    public function updatedPriceRange() { $this->resetPage(); }

    public function clearFilters()
    {
        $this->reset(['search', 'category_id', 'level', 'sort', 'price_range', 'rating_filter', 'duration_filter']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Course::with(['category', 'currentVersion.modules.lessons', 'trainer'])
            ->withCount('enrollments');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->level) {
            $query->whereHas('currentVersion', function ($q) {
                $q->where('level', $this->level);
            });
        }

        if ($this->sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($this->sort === 'price_low') {
            $query->orderBy(
                \App\Models\CourseVersion::select('price')
                    ->whereColumn('course_versions.course_id', 'courses.id')
                    ->limit(1),
                'asc'
            );
        } elseif ($this->sort === 'price_high') {
            $query->orderBy(
                \App\Models\CourseVersion::select('price')
                    ->whereColumn('course_versions.course_id', 'courses.id')
                    ->limit(1),
                'desc'
            );
        } else {
            // Popular / Default
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(12);
        $categories = Category::all();

        return view('livewire.public.courses.index', [
            'courses' => $courses,
            'categories' => $categories,
        ]);
    }
}
