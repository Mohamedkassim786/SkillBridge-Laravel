<?php

namespace App\Livewire\Admin\Companies;

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
#[Title('Company Management - SkillBridge Admin')]
class Manage extends Component
{
    use WithPagination;

    // Filters and Search
    public string $search = '';
    public string $selectedIndustry = '';
    public string $selectedVerification = '';
    public string $sortBy = 'jobs_count';

    // Modal state & Form fields
    public bool $showModal = false;
    public ?string $editingCompanyId = null;

    public string $name = '';
    public string $website = '';
    public string $location = 'Chennai, Tamil Nadu';
    public string $industry = 'IT Services';
    public string $contact_person = 'Rajesh Kumar, HR Manager';
    public string $email = 'hr@company.com';
    public string $phone = '+91 98765 43210';
    public string $is_verified = '1';

    public function mount()
    {
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedIndustry()
    {
        $this->resetPage();
    }

    public function updatingSelectedVerification()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editCompany(string $companyId)
    {
        $company = Company::find($companyId);
        if (! $company) {
            return;
        }

        $this->editingCompanyId = $company->id;
        $this->name = $company->name;
        $this->website = $company->website ?? '';
        $this->location = $company->location ?? 'Chennai, Tamil Nadu';
        $this->industry = $company->industry ?? 'IT Services';
        $this->contact_person = $company->contact_person ?? 'HR Manager';
        $this->email = $company->email ?? 'hr@company.com';
        $this->phone = $company->phone ?? '+91 98765 43210';
        $this->is_verified = $company->is_verified ? '1' : '0';

        $this->showModal = true;
    }

    public function saveCompany()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        if ($this->editingCompanyId) {
            $company = Company::findOrFail($this->editingCompanyId);
            $company->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'website' => $this->website,
                'location' => $this->location,
                'industry' => $this->industry,
                'contact_person' => $this->contact_person,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_verified' => (bool) $this->is_verified,
            ]);
            session()->flash('status', "Company '{$this->name}' updated successfully!");
        } else {
            Company::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'website' => $this->website,
                'location' => $this->location,
                'industry' => $this->industry,
                'contact_person' => $this->contact_person,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_verified' => (bool) $this->is_verified,
            ]);
            session()->flash('status', "New Company '{$this->name}' added successfully!");
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function verifyCompany(string $companyId)
    {
        $company = Company::find($companyId);
        if ($company) {
            $company->update(['is_verified' => true]);
            session()->flash('status', "Company '{$company->name}' is now verified!");
        }
    }

    public function deleteCompany(string $companyId)
    {
        $company = Company::find($companyId);
        if ($company) {
            $name = $company->name;
            $company->delete();
            session()->flash('status', "Company '{$name}' deleted successfully.");
        }
    }

    public function resetForm()
    {
        $this->editingCompanyId = null;
        $this->name = '';
        $this->website = '';
        $this->location = 'Chennai, Tamil Nadu';
        $this->industry = 'IT Services';
        $this->contact_person = 'Rajesh Kumar, HR Manager';
        $this->email = 'hr@company.com';
        $this->phone = '+91 98765 43210';
        $this->is_verified = '1';
    }

    public function render()
    {
        $query = Company::withCount('jobPostings');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%')
                  ->orWhere('industry', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedIndustry) {
            $query->where('industry', $this->selectedIndustry);
        }

        if ($this->selectedVerification !== '') {
            if ($this->selectedVerification === 'verified') {
                $query->where('is_verified', true);
            } elseif ($this->selectedVerification === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        $companies = $query->orderBy('created_at', 'desc')->get();

        // Real MySQL 8 Metrics
        $totalCompaniesCount = Company::count();
        $verifiedCompaniesCount = Company::where('is_verified', true)->count();
        $totalJobsCount = JobPosting::count();
        $totalHiredCount = JobApplication::where('status', 'hired')->count();

        return view('livewire.admin.companies.manage', [
            'companies' => $companies,
            'totalCompaniesCount' => $totalCompaniesCount,
            'verifiedCompaniesCount' => $verifiedCompaniesCount,
            'totalJobsCount' => $totalJobsCount,
            'totalHiredCount' => $totalHiredCount,
        ]);
    }
}
