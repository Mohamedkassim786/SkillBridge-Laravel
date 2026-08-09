<?php

namespace App\Livewire\SuperAdmin\Reports;

use App\Models\AuditLog;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\JobApplication;
use App\Models\Payment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Reports & Analytics Suite - Super Admin')]
class Analytics extends Component
{
    public string $dateRange = '30_days';
    public string $reportType = 'platform_overview';

    public function exportCsvReport()
    {
        $filename = "super_admin_report_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'report_exported_by_super_admin',
            'auditable_type' => AuditLog::class,
            'auditable_id' => 1,
            'new_values' => ['type' => $this->reportType, 'range' => $this->dateRange],
            'ip_address' => request()->ip(),
        ]);

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Report Metric', 'Value', 'Generated At']);
            fputcsv($file, ['Total Registered Students', User::role('student')->count(), date('Y-m-d H:i:s')]);
            fputcsv($file, ['Total Platform Revenue', '₹' . Payment::where('status', 'completed')->sum('amount'), date('Y-m-d H:i:s')]);
            fputcsv($file, ['Total Course Enrollments', Enrollment::count(), date('Y-m-d H:i:s')]);
            fputcsv($file, ['Total Hired Placements', JobApplication::where('status', 'hired')->count(), date('Y-m-d H:i:s')]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $studentGrowth = User::role('student')->where('created_at', '>=', now()->subDays(30))->count();
        $revenueTotal = Payment::where('status', 'completed')->sum('amount');
        $hiredTotal = JobApplication::where('status', 'hired')->count();
        $topCourses = Course::withCount('enrollments')->orderBy('enrollments_count', 'desc')->take(5)->get();

        return view('livewire.super-admin.reports.analytics', [
            'studentGrowth' => $studentGrowth,
            'revenueTotal' => $revenueTotal,
            'hiredTotal' => $hiredTotal,
            'topCourses' => $topCourses,
        ]);
    }
}
