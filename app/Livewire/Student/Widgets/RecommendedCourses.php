<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class RecommendedCourses extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.recommended-courses', [
            'courses' => $repository->getRecommendedCourses(auth()->user()),
        ]);
    }
}
