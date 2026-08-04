<?php

namespace App\Livewire\Student\Widgets;

use App\Domain\Student\Services\StudentDashboardService;
use Livewire\Component;

class WelcomeBanner extends Component
{
    public string $greeting = '';
    public string $name = '';
    public int $streak = 5;
    public string $batch = 'Cohort 2026 - Enterprise Software Architecture';

    public function mount(StudentDashboardService $service)
    {
        $this->greeting = $service->getGreetingTime();
        $this->name = auth()->user()?->first_name ?? 'Student';
    }

    public function render()
    {
        return view('livewire.student.widgets.welcome-banner');
    }
}
