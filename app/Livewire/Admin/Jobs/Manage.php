<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Job Management - SkillBridge Admin')]
class Manage extends Component
{
    use WithPagination;

    // Filters and Search
    public string $search = '';
    public string $selectedCompany = '';
    public string $selectedLocation = '';
    public string $selectedStatus = '';

    // Modal state & Form fields
    public bool $showModal = false;
    public ?string $editingJobId = null;

    public string $title = '';
    public ?string $company_id = null;
    public string $location = 'Chennai, Tamil Nadu';
    public float $salary_min = 500000;
    public float $salary_max = 800000;
    public string $description = '';
    public string $status = 'active';

    public function mount()
    {
        $firstCompany = Company::first();
        if ($firstCompany) {
            $this->company_id = $firstCompany->id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCompany()
    {
        $this->resetPage();
    }

    public function updatingSelectedLocation()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editJob(string $jobId)
    {
        $job = JobPosting::find($jobId);
        if (! $job) {
            return;
        }

        $this->editingJobId = $job->id;
        $this->title = $job->title;
        $this->company_id = $job->company_id;
        $this->location = $job->location;
        $this->salary_min = (float) ($job->salary_min ?? 500000);
        $this->salary_max = (float) ($job->salary_max ?? 800000);
        $this->description = $job->description ?? '';
        $this->status = $job->status ?? 'active';

        $this->showModal = true;
    }

    public function saveJob()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'location' => 'required|string|max:255',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|gte:salary_min',
            'description' => 'required|string|min:10',
            'status' => 'required|string|in:active,draft,closed,pending,rejected',
        ]);

        if ($this->editingJobId) {
            $job = JobPosting::findOrFail($this->editingJobId);
            $job->update([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'company_id' => $this->company_id,
                'location' => $this->location,
                'salary_min' => $this->salary_min,
                'salary_max' => $this->salary_max,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('status', "Job posting '{$this->title}' updated successfully!");
        } else {
            JobPosting::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'company_id' => $this->company_id,
                'location' => $this->location,
                'salary_min' => $this->salary_min,
                'salary_max' => $this->salary_max,
                'description' => $this->description,
                'status' => $this->status,
                'source' => 'internal',
            ]);
            session()->flash('status', "New Job posting '{$this->title}' created successfully!");
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function approveJob(string $jobId)
    {
        $job = JobPosting::find($jobId);
        if ($job) {
            $job->update(['status' => 'active']);
            session()->flash('status', "Job '{$job->title}' has been approved and published!");
        }
    }

    public function rejectJob(string $jobId)
    {
        $job = JobPosting::find($jobId);
        if ($job) {
            $job->update(['status' => 'closed']);
            session()->flash('status', "Job '{$job->title}' has been rejected.");
        }
    }

    public function syncAdzunaJobs(\App\Domain\Jobs\Services\AdzunaJobSyncService $syncService)
    {
        $count = $syncService->syncJobs('in', 'developer', 2);
        session()->flash('status', "📡 Adzuna API Sync complete! Imported {$count} live developer job postings into MySQL 8 database.");
    }

    public function deleteJob(string $jobId)
    {
        $job = JobPosting::find($jobId);
        if ($job) {
            $title = $job->title;
            $job->delete();
            session()->flash('status', "Job posting '{$title}' deleted successfully.");
        }
    }

    public function resetForm()
    {
        $this->editingJobId = null;
        $this->title = '';
        $this->location = 'Chennai, Tamil Nadu';
        $this->salary_min = 500000;
        $this->salary_max = 800000;
        $this->description = '';
        $this->status = 'active';

        $firstCompany = Company::first();
        if ($firstCompany) {
            $this->company_id = $firstCompany->id;
        }
    }

    public function render()
    {
        $query = JobPosting::with(['company', 'applications']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%')
                  ->orWhereHas('company', function ($cQuery) {
                      $cQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->selectedCompany) {
            $query->where('company_id', $this->selectedCompany);
        }

        if ($this->selectedLocation) {
            $query->where('location', 'like', '%' . $this->selectedLocation . '%');
        }

        if ($this->selectedStatus) {
            if ($this->selectedStatus === 'pending') {
                $query->where('status', 'draft');
            } elseif ($this->selectedStatus === 'expired') {
                $query->where('status', 'closed');
            } else {
                $query->where('status', $this->selectedStatus);
            }
        }

        $jobs = $query->orderBy('created_at', 'desc')->get();
        $companies = Company::all();

        // Real MySQL 8 Metrics
        $totalJobsCount = JobPosting::count();
        $activeJobsCount = JobPosting::where('status', 'active')->count();
        $pendingJobsCount = JobPosting::where('status', 'draft')->count();
        $totalApplicationsCount = JobApplication::count();

        return view('livewire.admin.jobs.manage', [
            'jobs' => $jobs,
            'companies' => $companies,
            'totalJobsCount' => $totalJobsCount,
            'activeJobsCount' => $activeJobsCount,
            'pendingJobsCount' => $pendingJobsCount,
            'totalApplicationsCount' => $totalApplicationsCount,
        ]);
    }
}
