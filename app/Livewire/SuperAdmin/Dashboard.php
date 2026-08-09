<?php

namespace App\Livewire\SuperAdmin;

use App\Models\AuditLog;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\LiveClass;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Super Admin Real-Time Metric Engine - SkillBridge')]
class Dashboard extends Component
{
    public function render()
    {
        // 1. Real-Time User Metrics
        $totalStudents = User::role('student')->count();
        $totalTrainers = User::role('staff')->count();
        $totalAdmins = User::role(['admin', 'super_admin'])->count();

        // 2. Course & Enrollment Metrics
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $pendingCourseApprovals = Course::whereHas('currentVersion', function ($q) {
            $q->where('is_published', false);
        })->count();

        // 3. Live Class Metrics
        $totalLiveClasses = LiveClass::count();
        $runningLiveClasses = LiveClass::where('status', 'live')->count();

        // 4. Jobs & Placements Metrics
        $totalJobs = JobPosting::count();
        $totalApplications = JobApplication::count();
        $totalPlacements = JobApplication::where('status', 'hired')->count();

        // 5. Finance & Payment Metrics
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $pendingTrainerApprovals = User::role('staff')->where('status', 'pending_verification')->count();

        // 6. System Alerts & Health Metrics
        $failedJobsCount = DB::table('failed_jobs')->count();

        // System Load Average (Windows fallback to CPU usage estimate)
        $cpuLoad = function_exists('sys_getloadavg') ? (sys_getloadavg()[0] ?? 0.15) : 0.25;
        $memoryUsageBytes = memory_get_usage(true);
        $memoryUsageFormatted = round($memoryUsageBytes / 1024 / 1024, 2) . ' MB';

        // 7. Recent Activity Logs & Audit Trail
        $recentAuditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('livewire.super-admin.dashboard', [
            'totalStudents' => $totalStudents,
            'totalTrainers' => $totalTrainers,
            'totalAdmins' => $totalAdmins,
            'totalCourses' => $totalCourses,
            'totalEnrollments' => $totalEnrollments,
            'pendingCourseApprovals' => $pendingCourseApprovals,
            'totalLiveClasses' => $totalLiveClasses,
            'runningLiveClasses' => $runningLiveClasses,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'totalPlacements' => $totalPlacements,
            'totalRevenue' => $totalRevenue,
            'pendingPayments' => $pendingPayments,
            'pendingTrainerApprovals' => $pendingTrainerApprovals,
            'failedJobsCount' => $failedJobsCount,
            'cpuLoad' => $cpuLoad,
            'memoryUsageFormatted' => $memoryUsageFormatted,
            'recentAuditLogs' => $recentAuditLogs,
        ]);
    }
}
