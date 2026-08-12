<div class="space-y-8">
    <!-- PAGE HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-rose-400">
                <span>🛡️ SUPER ADMIN ROOT CONTROLLER</span>
                <span>•</span>
                <span>REAL-TIME DB AGGREGATOR</span>
            </div>
            <h1 class="text-3xl font-black text-white mt-1">Super Admin Live Metric Center</h1>
            <p class="text-xs text-slate-300">All data calculated dynamically from MySQL production tables with zero static dummy stats.</p>
        </div>

        <div class="flex items-center gap-3">
            <div style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3);" class="px-4 py-2 rounded-2xl text-xs font-bold text-slate-300 flex items-center gap-2 shadow-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>CPU Load: {{ $cpuLoad * 100 }}%</span>
                <span class="text-slate-600">|</span>
                <span>RAM: {{ $memoryUsageFormatted }}</span>
            </div>
        </div>
    </div>

    <!-- METRIC CARDS GRID (4 Columns) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- 1. Total Students -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Students</span>
                <span class="text-blue-400">👥 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalStudents) }}</div>
            <div class="text-[11px] text-slate-400">Registered active student accounts</div>
        </div>

        <!-- 2. Total Trainers -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Trainers</span>
                <span class="text-amber-400">👨‍🏫 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalTrainers) }}</div>
            <div class="text-[11px] text-slate-400">Instructors & staff members</div>
        </div>

        <!-- 3. Total Admins -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Admins</span>
                <span class="text-purple-400">🔑 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalAdmins) }}</div>
            <div class="text-[11px] text-slate-400">Admins & Super Admin roots</div>
        </div>

        <!-- 4. Total Courses -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Courses</span>
                <span class="text-emerald-400">📚 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalCourses) }}</div>
            <div class="text-[11px] text-slate-400">Active catalog course modules</div>
        </div>

        <!-- 5. Total Enrollments -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Enrollments</span>
                <span class="text-cyan-400">🎓 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalEnrollments) }}</div>
            <div class="text-[11px] text-slate-400">Course enrollment records</div>
        </div>

        <!-- 6. Total Live Classes -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Live Classes</span>
                <span class="text-rose-400">🎥 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalLiveClasses) }}</div>
            <div class="text-[11px] text-slate-400">Scheduled & completed sessions</div>
        </div>

        <!-- 7. Running Live Classes -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Running Live Now</span>
                <span class="px-2 py-0.5 rounded-full bg-red-500/20 text-red-400 text-[10px] animate-pulse">🔴 LIVE</span>
            </div>
            <div class="text-3xl font-black text-rose-400">{{ number_format($runningLiveClasses) }}</div>
            <div class="text-[11px] text-slate-400">Sessions actively streaming</div>
        </div>

        <!-- 8. Total Jobs & Applications -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Jobs Marketplace</span>
                <span class="text-indigo-400">💼 DB</span>
            </div>
            <div class="text-3xl font-black text-white">{{ number_format($totalJobs) }}</div>
            <div class="text-[11px] text-slate-400">{{ number_format($totalApplications) }} student applications</div>
        </div>

        <!-- 9. Total Placements -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Hired Placements</span>
                <span class="text-emerald-400">🏆 DB</span>
            </div>
            <div class="text-3xl font-black text-emerald-400">{{ number_format($totalPlacements) }}</div>
            <div class="text-[11px] text-slate-400">Students with accepted offers</div>
        </div>

        <!-- 10. Total Revenue -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Total Revenue</span>
                <span class="text-emerald-400">₹ DB</span>
            </div>
            <div class="text-3xl font-black text-emerald-400">₹{{ number_format($totalRevenue) }}</div>
            <div class="text-[11px] text-slate-400">Completed transaction total</div>
        </div>

        <!-- 11. Pending Approvals Bar -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>Pending Approvals</span>
                <span class="text-amber-400">⏳ DB</span>
            </div>
            <div class="text-3xl font-black text-amber-400">{{ number_format($pendingCourseApprovals + $pendingTrainerApprovals) }}</div>
            <div class="text-[11px] text-slate-400">{{ $pendingCourseApprovals }} courses • {{ $pendingTrainerApprovals }} trainers</div>
        </div>

        <!-- 12. Failed Jobs & Errors -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wider">
                <span>System Failed Jobs</span>
                <span class="text-rose-400">⚠️ DB</span>
            </div>
            <div class="text-3xl font-black {{ $failedJobsCount > 0 ? 'text-rose-400' : 'text-slate-300' }}">{{ number_format($failedJobsCount) }}</div>
            <div class="text-[11px] text-slate-400">Queue processing error records</div>
        </div>

    </div>

    <!-- RECENT SYSTEM ACTIVITY & AUDIT TRAIL TABLE -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.3);" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-black text-white flex items-center gap-2">
                <span>📋 Recent System Audit Logs</span>
            </h3>
            <a href="{{ route('super_admin.security.audit-logs') }}" class="text-xs font-bold text-rose-400 hover:underline text-decoration-none">View All Audit Logs ➔</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Action</th>
                        <th class="py-3 px-4">Entity Type</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($recentAuditLogs as $log)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3 px-4 font-bold text-white">{{ $log->user?->name ?? 'System' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400">{{ class_basename($log->auditable_type ?? 'N/A') }} #{{ $log->auditable_id }}</td>
                            <td class="py-3 px-4 font-mono text-[11px] text-slate-400">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                            <td class="py-3 px-4 text-slate-400">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No audit logs recorded yet. All system actions will log automatically.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
