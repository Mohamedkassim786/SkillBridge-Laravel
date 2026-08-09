<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Platform Analytics & Intelligence Reports</h1>
            <p class="text-xs text-slate-300">Generate real-time analytics for user growth, course enrollment revenue, student engagement, and placement reports.</p>
        </div>

        <button wire:click="exportCsvReport" style="background-color: #D62828;" class="px-5 py-2.5 rounded-2xl text-white font-black text-xs shadow-lg hover:bg-rose-700 transition flex items-center gap-2">
            📊 Export CSV Report
        </button>
    </div>

    <!-- METRICS OVERVIEW CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">30-Day Student Growth</div>
            <div class="text-3xl font-black text-blue-400">+{{ number_format($studentGrowth) }}</div>
            <div class="text-[11px] text-slate-400">New student registrations</div>
        </div>

        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Completed Gross Revenue</div>
            <div class="text-3xl font-black text-emerald-400">₹{{ number_format($revenueTotal) }}</div>
            <div class="text-[11px] text-slate-400">Total course sales total</div>
        </div>

        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl shadow-xl space-y-2 text-white">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">Verified Placements</div>
            <div class="text-3xl font-black text-purple-400">{{ number_format($hiredTotal) }} Hired</div>
            <div class="text-[11px] text-slate-400">Career placement success</div>
        </div>
    </div>

    <!-- TOP PERFORMING COURSES REPORT CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <h3 class="text-base font-black text-white">Top Enrolled Courses Performance</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Course Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Active Enrollments</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach ($topCourses as $c)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white">{{ $c->title }}</td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $c->category?->name ?? 'Software Engineering' }}</td>
                            <td class="py-3.5 px-4 font-bold text-cyan-400">{{ $c->enrollments_count }} students</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
