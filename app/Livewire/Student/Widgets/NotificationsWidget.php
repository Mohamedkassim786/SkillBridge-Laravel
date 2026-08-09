<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Contracts\StudentDashboardRepositoryInterface;
use Livewire\Component;

class NotificationsWidget extends Component
{
    public function render(StudentDashboardRepositoryInterface $repository)
    {
        return view('livewire.student.widgets.notifications-widget', [
            'notifications' => $repository->getNotifications(auth()->user()),
        ]);
    }
}
