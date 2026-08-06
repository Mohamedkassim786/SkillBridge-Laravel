<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Reports & Analytics - SkillBridge Admin')]
class Index extends Component
{
    public string $activeTab = 'overview';
    public string $dateRange = '30_days';

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // Real MySQL 8 Metrics
        $activeStudents = User::role('student')->count();
        $totalCourses = Course::count();
        $completedEnrollments = Enrollment::where('status', 'completed')->count();
        $jobApplications = JobApplication::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $trainerCount = User::role('staff')->count();

        return view('livewire.admin.reports.index', compact(
            'activeStudents',
            'totalCourses',
            'completedEnrollments',
            'jobApplications',
            'totalRevenue',
            'trainerCount'
        ));
    }
}
