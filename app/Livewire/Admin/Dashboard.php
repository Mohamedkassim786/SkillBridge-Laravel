<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Payment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Admin Dashboard - SkillBridge Enterprise')]
class Dashboard extends Component
{
    public string $period = 'this_month';

    public function render()
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $totalStudents = User::role('student')->count();
        $totalCourses = Course::count();
        $totalJobs = JobPosting::count();

        // Real Recent Enrollments from MySQL 8
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Real Recent Job Applications from MySQL 8
        $recentApplications = JobApplication::with(['jobPosting.company', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Real System Activity Logs from MySQL 8
        $activityLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalRevenue',
            'totalStudents',
            'totalCourses',
            'totalJobs',
            'recentEnrollments',
            'recentApplications',
            'activityLogs'
        ));
    }
}
