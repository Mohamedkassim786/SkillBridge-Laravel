<x-layouts.staff>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="{{ route('staff.live-classes.index') }}" class="hover:text-rose-400 text-decoration-none">Live Classes</a>
                    <span>/</span>
                    <a href="{{ route('staff.live-classes.show', $liveClass->id) }}" class="hover:text-rose-400 text-decoration-none">{{ $liveClass->title }}</a>
                    <span>/</span>
                    <span class="text-white">Attendance</span>
                </div>
                <h1 class="text-2xl font-black text-white mt-1">Real Attendance Report: {{ $liveClass->title }}</h1>
            </div>

            <a href="{{ route('staff.live-classes.export-attendance', $liveClass->id) }}" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md text-decoration-none flex items-center gap-2">
                <span>📥 Export Attendance CSV</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Attendance Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white">
                <div class="text-xs text-slate-400 font-bold uppercase">Enrolled Students</div>
                <div class="text-3xl font-black text-white mt-1">{{ $totalEnrolled }}</div>
            </div>

            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white">
                <div class="text-xs text-slate-400 font-bold uppercase">Attended Students</div>
                <div class="text-3xl font-black text-emerald-400 mt-1">{{ $attendedCount }}</div>
            </div>

            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl text-white">
                <div class="text-xs text-slate-400 font-bold uppercase">Attendance Percentage</div>
                <div class="text-3xl font-black text-purple-400 mt-1">{{ $attendancePercentage }}%</div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl shadow-xl overflow-hidden text-white">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <h3 class="text-base font-black text-white">Student Audit Log</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900/60 uppercase text-[10px] font-black text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="p-4">Student Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Joined Time</th>
                            <th class="p-4">Left Time</th>
                            <th class="p-4">Duration</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 font-semibold">
                        @forelse ($liveClass->attendees as $att)
                            <tr class="hover:bg-white/5 transition">
                                <td class="p-4 font-bold text-white">{{ $att->student?->name ?? 'Student' }}</td>
                                <td class="p-4 text-slate-300">{{ $att->student?->email ?? 'N/A' }}</td>
                                <td class="p-4 text-slate-300">{{ $att->joined_at ? $att->joined_at->format('M d @ h:i A') : 'N/A' }}</td>
                                <td class="p-4 text-slate-300">{{ $att->left_at ? $att->left_at->format('M d @ h:i A') : 'N/A' }}</td>
                                <td class="p-4 font-mono text-white">{{ $att->duration_minutes }} mins</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border
                                        {{ $att->attendance_status === 'attended' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                        {{ $att->attendance_status === 'partial' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : '' }}
                                        {{ $att->attendance_status === 'joined' ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}
                                        {{ $att->attendance_status === 'absent' ? 'bg-rose-500/20 text-rose-300 border-rose-500/30' : '' }}">
                                        {{ strtoupper($att->attendance_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">No attendance records generated yet for this session.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.staff>
