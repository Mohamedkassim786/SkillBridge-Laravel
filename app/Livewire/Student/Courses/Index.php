<?php

namespace App\Livewire\Student\Courses;

use App\Domain\Student\Contracts\CourseRepositoryInterface;
use App\Models\Category;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.student')]
#[Title('My Courses - SkillBridge')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all';
    public string $category_id = '';
    public string $trainer_id = '';
    public string $difficulty = '';
    public string $sort = 'recently_accessed';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
    }

    public function updatedTrainerId()
    {
        $this->resetPage();
    }

    public function updatedDifficulty()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'status', 'category_id', 'trainer_id', 'difficulty', 'sort']);
        $this->resetPage();
    }

    public function render(CourseRepositoryInterface $courseRepository)
    {
        $courses = $courseRepository->getStudentCourses(auth()->user(), [
            'search' => $this->search,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'trainer_id' => $this->trainer_id,
            'difficulty' => $this->difficulty,
            'sort' => $this->sort,
        ]);

        $categories = Category::orderBy('name')->get();
        $trainers = User::role('staff')->orderBy('first_name')->get();

        return view('livewire.student.courses.index', [
            'courses' => $courses,
            'categories' => $categories,
            'trainers' => $trainers,
        ]);
    }
}
