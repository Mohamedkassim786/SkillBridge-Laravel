<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class CareerProgress extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.career-progress', [
            'progress' => $repository->getCareerProgress(auth()->user()),
        ]);
    }
}
