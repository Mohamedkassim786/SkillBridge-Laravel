<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class UpcomingQuizzes extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.upcoming-quizzes', [
            'quizzes' => $repository->getUpcomingQuizzes(auth()->user()),
        ]);
    }
}
