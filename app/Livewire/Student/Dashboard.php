<?php

namespace App\Livewire\Student;

use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\JobApplication;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Student Dashboard - SkillBridge')]
class Dashboard extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $enrolledCourses = Enrollment::with(['course.currentVersion', 'course.trainer'])
            ->where('user_id', $userId)
            ->get();

        $completedCoursesCount = Enrollment::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $certificatesCount = Certificate::where('user_id', $userId)->count();

        $jobApplicationsCount = JobApplication::where('user_id', $userId)->count();

        return view('livewire.student.dashboard', compact(
            'enrolledCourses',
            'completedCoursesCount',
            'certificatesCount',
            'jobApplicationsCount'
        ));
    }
}
