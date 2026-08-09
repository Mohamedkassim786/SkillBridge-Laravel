<?php

namespace App\Livewire\SuperAdmin\Applications;

use App\Models\AuditLog;
use App\Models\JobApplication;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Job Applications & Placements Pipeline - Super Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    public function updatedStatusFilter() { $this->resetPage(); }

    public function updateApplicationStatus(string $appId, string $newStatus)
    {
        $app = JobApplication::findOrFail($appId);
        $app->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'job_application_status_changed_by_super_admin',
            'auditable_type' => JobApplication::class,
            'auditable_id' => $appId,
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Application status updated to " . strtoupper($newStatus));
    }

    public function render()
    {
        $query = JobApplication::with(['user', 'jobPosting.company']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.super-admin.applications.manage', [
            'applications' => $applications,
        ]);
    }
}
