<div class="space-y-6">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white">Live Classes Monitor & Attendance Engine</h1>
            <p class="text-xs text-slate-300">Track active sessions, verify participant join/leave times, publish/delete recordings, and correct attendance records.</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-4 rounded-3xl shadow-xl flex items-center justify-between">
        <div class="text-xs font-bold text-slate-300">Filter Session Status:</div>

        <select wire:model.live="statusFilter" style="background: #112240; border: 1px solid #1e3a5f; color: white;" class="px-3 py-2.5 rounded-xl text-xs font-bold focus:outline-none">
            <option value="">All Statuses</option>
            <option value="live">🔴 Live Now</option>
            <option value="scheduled">Scheduled</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <!-- LIVE CLASSES TABLE CARD -->
    <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 text-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-extrabold tracking-wider">
                        <th class="py-3 px-4">Session Title</th>
                        <th class="py-3 px-4">Course</th>
                        <th class="py-3 px-4">Trainer</th>
                        <th class="py-3 px-4">Start Time</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Attendees</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    @forelse ($liveClasses as $lc)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-bold text-white max-w-xs">{{ $lc->title }}</td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $lc->course?->title ?? 'General Masterclass' }}</td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $lc->trainer?->name ?? 'Senior Trainer' }}</td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono">{{ $lc->start_at->format('M d, Y @ h:i A') }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border
                                    {{ $lc->status === 'live' ? 'bg-red-500/20 text-red-400 border-red-500/30 animate-pulse' : '' }}
                                    {{ $lc->status === 'scheduled' ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}
                                    {{ $lc->status === 'completed' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                    {{ $lc->status === 'cancelled' ? 'bg-slate-800 text-slate-400 border-slate-700' : '' }}">
                                    {{ strtoupper($lc->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-cyan-400">{{ $lc->attendees->count() }} students</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button wire:click="viewAttendance('{{ $lc->id }}')" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold">
                                    Attendance
                                </button>

                                @if ($lc->status === 'live')
                                    <button wire:click="updateClassStatus('{{ $lc->id }}', 'completed')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold">
                                        End Session
                                    </button>
                                @elseif ($lc->status === 'scheduled')
                                    <button wire:click="updateClassStatus('{{ $lc->id }}', 'live')" style="background-color: #D62828;" class="px-3 py-1.5 rounded-xl text-white text-[11px] font-bold shadow-md">
                                        Start Live
                                    </button>
                                    <button wire:click="updateClassStatus('{{ $lc->id }}', 'cancelled')" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold">
                                        Cancel
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">No live classes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($liveClasses->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $liveClasses->links() }}
            </div>
        @endif
    </div>

    <!-- ATTENDANCE MODAL -->
    @if ($selectedClassForAttendance)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-2xl max-w-3xl w-full text-white space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-black text-white">Attendance Audit Log: {{ $selectedClassForAttendance->title }}</h3>
                    <button wire:click="$set('selectedClassForAttendance', null)" class="text-slate-400 hover:text-white text-xs">✕ Close</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-800 uppercase text-[10px] font-bold">
                                <th class="py-2.5 px-3">Student Name</th>
                                <th class="py-2.5 px-3">Joined Time</th>
                                <th class="py-2.5 px-3">Duration (Mins)</th>
                                <th class="py-2.5 px-3">Status</th>
                                <th class="py-2.5 px-3 text-right">Correct Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-slate-300">
                            @forelse ($attendees as $att)
                                <tr>
                                    <td class="py-2.5 px-3 font-bold text-white">{{ $att->student?->name ?? 'Student' }}</td>
                                    <td class="py-2.5 px-3 font-mono text-slate-400">{{ $att->joined_at ? $att->joined_at->format('H:i:s') : 'N/A' }}</td>
                                    <td class="py-2.5 px-3 font-bold text-cyan-400">{{ $att->duration_minutes }} mins</td>
                                    <td class="py-2.5 px-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase bg-slate-800 text-emerald-400 border border-slate-700">
                                            {{ $att->attendance_status }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right space-x-1">
                                        <button wire:click="correctAttendanceStatus('{{ $att->id }}', 'attended')" class="px-2 py-1 rounded bg-emerald-600/80 text-white text-[10px] font-bold">Attended</button>
                                        <button wire:click="correctAttendanceStatus('{{ $att->id }}', 'partial')" class="px-2 py-1 rounded bg-amber-600/80 text-white text-[10px] font-bold">Partial</button>
                                        <button wire:click="correctAttendanceStatus('{{ $att->id }}', 'absent')" class="px-2 py-1 rounded bg-rose-600/80 text-white text-[10px] font-bold">Absent</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">No student attendance logs for this session.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
