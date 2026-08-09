<?php

namespace App\Livewire\SuperAdmin\Jobs;

use App\Models\AuditLog;
use App\Models\JobPosting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Job Postings & Approval Marketplace - Super Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    public function toggleFeatured(string $jobId)
    {
        $job = JobPosting::findOrFail($jobId);
        $job->update(['is_featured' => ! $job->is_featured]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'job_featured_toggled',
            'auditable_type' => JobPosting::class,
            'auditable_id' => $jobId,
            'new_values' => ['is_featured' => $job->is_featured],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Featured status toggled for {$job->title}");
    }

    public function deleteJob(string $jobId)
    {
        $job = JobPosting::findOrFail($jobId);
        $job->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'job_posting_deleted',
            'auditable_type' => JobPosting::class,
            'auditable_id' => $jobId,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Job posting removed cleanly.");
    }

    public function render()
    {
        $query = JobPosting::with('company');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.super-admin.jobs.manage', [
            'jobs' => $jobs,
        ]);
    }
}
