<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class RecommendedJobs extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.recommended-jobs', [
            'jobs' => $repository->getRecommendedJobs(auth()->user()),
        ]);
    }
}
