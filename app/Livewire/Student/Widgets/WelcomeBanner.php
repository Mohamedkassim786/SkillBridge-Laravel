<?php

namespace App\Livewire\Student\Widgets;

use App\Models\Enrollment;
use Livewire\Component;

class WelcomeBanner extends Component
{
    public function render()
    {
        $user = auth()->user();
        $hour = (int) date('H');
        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
        $enrollment = Enrollment::with('cohort')->where('user_id', $user?->id)->first();
        $batch = $enrollment?->cohort?->name ?? 'Cohort 2026';

        return view('livewire.student.widgets.welcome-banner', [
            'user' => $user,
            'name' => $user?->name ?? 'Student',
            'greeting' => $greeting,
            'streak' => 1,
            'batch' => $batch,
        ]);
    }
}
