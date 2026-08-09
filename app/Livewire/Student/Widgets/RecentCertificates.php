<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class RecentCertificates extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.recent-certificates', [
            'certificates' => $repository->getRecentCertificates(auth()->user()),
        ]);
    }
}
