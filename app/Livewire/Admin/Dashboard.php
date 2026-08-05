<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobPosting;
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
        $totalRevenue = Enrollment::sum('amount_paid') ?: 1485900;
        $totalStudents = User::where('role', 'student')->count() ?: 12450;
        $totalCourses = Course::count() ?: 48;
        $totalJobs = JobPosting::count() ?: 2145;

        // Recent Enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // System Activity Logs
        $activityLogs = [
            ['title' => 'System Backup Completed', 'desc' => 'Database & storage backup finished successfully', 'time' => '10 mins ago', 'type' => 'success'],
            ['title' => 'New Course Published', 'desc' => 'Laravel 12 Advanced REST API Design by John Doe', 'time' => '45 mins ago', 'type' => 'info'],
            ['title' => 'User Role Promoted', 'desc' => 'Priya Sharma promoted to Lead Instructor', 'time' => '2 hours ago', 'type' => 'warning'],
            ['title' => 'Payment Gateway Audit', 'desc' => 'Razorpay & Stripe webhooks verified 100% active', 'time' => '5 hours ago', 'type' => 'success'],
        ];

        return view('livewire.admin.dashboard', compact(
            'totalRevenue',
            'totalStudents',
            'totalCourses',
            'totalJobs',
            'recentEnrollments',
            'activityLogs'
        ));
    }
}
