<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class PendingAssignments extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.pending-assignments', [
            'assignments' => $repository->getPendingAssignments(auth()->user()),
        ]);
    }
}
