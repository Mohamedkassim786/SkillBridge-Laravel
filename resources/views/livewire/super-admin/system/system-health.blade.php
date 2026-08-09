<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Live System Health & Server Hardware Monitor</h1>
            <p class="text-xs text-slate-300">Monitor real host CPU load, PHP memory usage, disk allocation, database connection health, and queue metrics.</p>
        </div>
    </div>

    <!-- HARDWARE METRICS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- CPU Load -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Host CPU Load</div>
            <div class="text-3xl font-black text-emerald-400">{{ round($cpuLoad * 100, 1) }}%</div>
            <div class="text-[11px] text-slate-400">System load average</div>
        </div>

        <!-- RAM Usage -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">PHP RAM Usage</div>
            <div class="text-3xl font-black text-cyan-400">{{ $memoryUsageMb }} MB</div>
            <div class="text-[11px] text-slate-400">Peak: {{ $memoryPeakMb }} MB</div>
        </div>

        <!-- Disk Allocation -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Storage Disk Space</div>
            <div class="text-3xl font-black text-purple-400">{{ $diskFreeGb }} GB Free</div>
            <div class="text-[11px] text-slate-400">{{ $diskUsedPercent }}% disk space used (Total {{ $diskTotalGb }} GB)</div>
        </div>

        <!-- Database Health -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Database Status</div>
            <div class="text-2xl font-black text-emerald-400">✓ {{ $dbStatus }}</div>
            <div class="text-[11px] text-slate-400">MySQL Connection Port 3306</div>
        </div>
    </div>

    <!-- ENVIRONMENT SPECIFICATIONS & QUEUE STATUS CARD -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-base font-black text-white">Environment Specifications</h3>
            
            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400 font-semibold">PHP Engine Version</span>
                    <span class="font-mono font-bold text-white">{{ $phpVersion }}</span>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400 font-semibold">Laravel Framework Version</span>
                    <span class="font-mono font-bold text-rose-400">{{ $laravelVersion }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-semibold">Database Engine</span>
                    <span class="font-mono font-bold text-white">MySQL 8.4 (Laragon)</span>
                </div>
            </div>
        </div>

        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-4 text-white">
            <h3 class="text-base font-black text-white">Queue & Background Tasks Status</h3>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400 font-semibold">Pending Queue Jobs</span>
                    <span class="font-bold text-cyan-400">{{ $pendingJobsCount }} jobs</span>
                </div>

                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-slate-400 font-semibold">Failed Queue Jobs</span>
                    <span class="font-bold {{ $failedJobsCount > 0 ? 'text-rose-400' : 'text-slate-300' }}">{{ $failedJobsCount }} errors</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-semibold">Queue Driver</span>
                    <span class="font-mono font-bold text-white">sync / database</span>
                </div>
            </div>
        </div>
    </div>
</div>
