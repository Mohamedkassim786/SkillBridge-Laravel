<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class ContinueLearning extends Component
{
    public ?array $activeCourse = null;

    public function mount(StudentDashboardRepositoryInterface $repository)
    {
        $this->activeCourse = $repository->getLastActiveCourse(auth()->user());
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm animate-pulse space-y-4">
            <x-skeleton class="h-4 w-32" />
            <x-skeleton class="h-6 w-3/4" />
            <x-skeleton class="h-3 w-1/2" />
            <x-skeleton class="h-3 w-full" />
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.student.widgets.continue-learning');
    }
}
