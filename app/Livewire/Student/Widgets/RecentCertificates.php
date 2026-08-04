<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Illuminate\Support\Collection;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class RecentCertificates extends Component
{
    public Collection $certificates;

    public function mount(StudentDashboardRepositoryInterface $repository)
    {
        $this->certificates = $repository->getRecentCertificates(auth()->user());
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm animate-pulse space-y-3">
            <x-skeleton class="h-4 w-32" />
            <x-skeleton class="h-12 w-full" />
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.student.widgets.recent-certificates');
    }
}
