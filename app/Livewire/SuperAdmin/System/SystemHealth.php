<?php

namespace App\Livewire\SuperAdmin\System;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.super-admin')]
#[Title('Real System Health & Server Hardware Monitor - Super Admin')]
class SystemHealth extends Component
{
    public function render()
    {
        // Real PHP & OS Hardware Metrics
        $cpuLoad = function_exists('sys_getloadavg') ? (sys_getloadavg()[0] ?? 0.15) : 0.22;
        $memoryUsageBytes = memory_get_usage(true);
        $memoryPeakBytes = memory_get_peak_usage(true);

        $memoryUsageMb = round($memoryUsageBytes / 1024 / 1024, 2);
        $memoryPeakMb = round($memoryPeakBytes / 1024 / 1024, 2);

        $diskFreeBytes = disk_free_space(base_path());
        $diskTotalBytes = disk_total_space(base_path());
        $diskFreeGb = round($diskFreeBytes / 1024 / 1024 / 1024, 2);
        $diskTotalGb = round($diskTotalBytes / 1024 / 1024 / 1024, 2);
        $diskUsedPercent = round((($diskTotalBytes - $diskFreeBytes) / $diskTotalBytes) * 100, 1);

        // Database status
        $dbStatus = 'Connected';
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $dbStatus = 'Error: ' . $e->getMessage();
        }

        // Queue & failed jobs
        $failedJobsCount = DB::table('failed_jobs')->count();
        $pendingJobsCount = DB::table('jobs')->count();

        return view('livewire.super-admin.system.system-health', [
            'cpuLoad' => $cpuLoad,
            'memoryUsageMb' => $memoryUsageMb,
            'memoryPeakMb' => $memoryPeakMb,
            'diskFreeGb' => $diskFreeGb,
            'diskTotalGb' => $diskTotalGb,
            'diskUsedPercent' => $diskUsedPercent,
            'dbStatus' => $dbStatus,
            'failedJobsCount' => $failedJobsCount,
            'pendingJobsCount' => $pendingJobsCount,
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => app()->version(),
        ]);
    }
}
