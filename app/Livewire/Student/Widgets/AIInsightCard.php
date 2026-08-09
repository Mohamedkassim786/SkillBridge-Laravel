<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class AIInsightCard extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.ai-insight-card', [
            'insight' => $repository->getAIInsights(auth()->user()),
        ]);
    }
}
