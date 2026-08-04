<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class LearningStatistics extends Component
{
    public array $stats = [];

    public function mount(StudentDashboardRepositoryInterface $repository)
    {
        $this->stats = $repository->getLearningStats(auth()->user());
    }

    public function placeholder()
    {
        return view('livewire.student.widgets.placeholders.stats-skeleton');
    }

    public function render()
    {
        return view('livewire.student.widgets.learning-statistics');
    }
}
