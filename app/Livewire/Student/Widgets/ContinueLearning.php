<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class ContinueLearning extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.continue-learning', [
            'activeCourse' => $repository->getLastActiveCourse(auth()->user()),
        ]);
    }
}
