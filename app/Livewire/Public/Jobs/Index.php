<?php

namespace App\Livewire\Public\Jobs;

use App\Models\JobPosting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.public')]
#[Title('Find Your Dream Job - SkillBridge')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $job_type = '';
    public string $experience_level = '';
    public string $location = '';
    public string $work_mode = '';
    public string $salary_range = '30';
    public string $skill = '';
    public string $company = '';
    public string $sort = 'newest';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedJobType() { $this->resetPage(); }
    public function updatedExperienceLevel() { $this->resetPage(); }
    public function updatedLocation() { $this->resetPage(); }
    public function updatedSort() { $this->resetPage(); }

    public function clearFilters()
    {
        $this->reset(['search', 'job_type', 'experience_level', 'location', 'work_mode', 'salary_range', 'skill', 'company', 'sort']);
        $this->resetPage();
    }

    public function render()
    {
        $query = JobPosting::with('company');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->location) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.public.jobs.index', compact('jobs'));
    }
}
