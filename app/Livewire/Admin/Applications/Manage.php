<?php

namespace App\Livewire\Admin\Applications;

use App\Models\JobApplication;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Job Applications Management - SkillBridge Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedStatus = '';
    public string $dateRange = '30_days';

    // Status update modal
    public bool $showModal = false;
    public ?string $selectedAppId = null;
    public string $newStatus = 'submitted';
    public string $comment = '';

    public function mount()
    {
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function openStatusModal(string $appId)
    {
        $app = JobApplication::find($appId);
        if ($app) {
            $this->selectedAppId = $app->id;
            $this->newStatus = $app->status;
            $this->comment = '';
            $this->showModal = true;
        }
    }

    public function updateStatus()
    {
        if (! $this->selectedAppId) {
            return;
        }

        $app = JobApplication::findOrFail($this->selectedAppId);
        $oldStatus = $app->status;
        $app->update(['status' => $this->newStatus]);

        session()->flash('status', "Application status updated from '{$oldStatus}' to '{$this->newStatus}'!");
        $this->showModal = false;
    }

    public function render()
    {
        $query = JobApplication::with(['jobPosting.company', 'user', 'resume']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($uQuery) {
                    $uQuery->where('first_name', 'like', '%' . $this->search . '%')
                           ->orWhere('last_name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhereHas('jobPosting', function ($jQuery) {
                    $jQuery->where('title', 'like', '%' . $this->search . '%');
                });
            });
        }

        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        // Real MySQL 8 Metrics
        $totalAppsCount = JobApplication::count();
        $shortlistedCount = JobApplication::where('status', 'shortlisted')->count();
        $interviewCount = JobApplication::where('status', 'interview_scheduled')->count();
        $hiredCount = JobApplication::where('status', 'hired')->count();

        return view('livewire.admin.applications.manage', [
            'applications' => $applications,
            'totalAppsCount' => $totalAppsCount,
            'shortlistedCount' => $shortlistedCount,
            'interviewCount' => $interviewCount,
            'hiredCount' => $hiredCount,
        ]);
    }
}
