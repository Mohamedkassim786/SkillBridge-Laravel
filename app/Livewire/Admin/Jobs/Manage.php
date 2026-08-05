<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\JobPosting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Job Openings Management - Admin Portal')]
class Manage extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $jobs = JobPosting::with('company')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.jobs.manage', compact('jobs'));
    }
}
