<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class LearningCalendar extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.learning-calendar', [
            'events' => $repository->getCalendarEvents(auth()->user()),
        ]);
    }
}
