<?php

namespace App\Livewire\SuperAdmin\Companies;

use App\Models\AuditLog;
use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.super-admin')]
#[Title('Company Approval & Verification - Super Admin')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch() { $this->resetPage(); }

    public function toggleVerification(string $companyId)
    {
        $company = Company::findOrFail($companyId);
        $newStatus = ($company->status ?? 'approved') === 'approved' ? 'suspended' : 'approved';
        $company->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'company_status_toggled',
            'auditable_type' => Company::class,
            'auditable_id' => $companyId,
            'new_values' => ['status' => $newStatus],
            'ip_address' => request()->ip(),
        ]);

        session()->flash('status', "Company status changed to " . strtoupper($newStatus));
    }

    public function render()
    {
        $query = Company::withCount('jobPostings');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $companies = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.super-admin.companies.manage', [
            'companies' => $companies,
        ]);
    }
}
