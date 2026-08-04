<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class AIInsightCard extends Component
{
    public array $insight = [];

    public function mount(StudentDashboardRepositoryInterface $repository)
    {
        $this->insight = $repository->getAIInsights(auth()->user());
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm animate-pulse space-y-3">
            <x-skeleton class="h-4 w-32" />
            <x-skeleton class="h-16 w-full" />
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.student.widgets.ai-insight-card');
    }
}
