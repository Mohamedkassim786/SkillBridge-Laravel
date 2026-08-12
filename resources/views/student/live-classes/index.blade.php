<x-layouts.student>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-white">My Live Masterclasses</h1>
                <p class="text-xs text-slate-300 mt-1">Access scheduled live interactive sessions for your enrolled courses and cohorts.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Masterclasses Responsive Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($liveClasses as $lc)
                @php
                    $userAttended = $lc->attendees->first();
                @endphp

                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl p-6 shadow-xl space-y-4 flex flex-col justify-between text-white">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase border
                                {{ $lc->status === 'live' ? 'bg-red-500/20 text-red-400 border-red-500/30 animate-pulse' : '' }}
                                {{ $lc->status === 'starting_soon' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : '' }}
                                {{ $lc->status === 'scheduled' ? 'bg-blue-500/20 text-blue-300 border-blue-500/30' : '' }}
                                {{ $lc->status === 'completed' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : '' }}
                                {{ $lc->status === 'cancelled' ? 'bg-slate-800 text-slate-400 border-slate-700' : '' }}">
                                {{ strtoupper(str_replace('_', ' ', $lc->status)) }}
                            </span>
                            <span class="text-xs text-slate-400 font-bold">⏱️ {{ $lc->duration_minutes }} mins</span>
                        </div>

                        <h3 class="text-lg font-black text-white leading-snug">{{ $lc->title }}</h3>

                        <div class="text-xs text-slate-300 space-y-1">
                            <div>📚 <strong>Course:</strong> {{ $lc->course?->title }}</div>
                            <div>👨‍🏫 <strong>Trainer:</strong> {{ $lc->trainer?->name ?? 'Enterprise Instructor' }}</div>
                            <div>📅 <strong>Start:</strong> {{ $lc->start_at->format('M d, Y @ h:i A') }}</div>
                        </div>

                        @if ($userAttended)
                            <div class="p-2.5 rounded-xl bg-slate-900/60 border border-slate-800 text-xs flex items-center justify-between">
                                <span class="text-slate-400">My Attendance:</span>
                                <span class="font-bold text-emerald-400 uppercase">{{ $userAttended->attendance_status }} ({{ $userAttended->duration_minutes }}m)</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
                        <a href="{{ route('student.live-classes.show', $lc->id) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold text-decoration-none">
                            Class Details ➔
                        </a>

                        @if (in_array($lc->status, ['scheduled', 'starting_soon', 'live']))
                            <a href="{{ route('student.live-classes.join', $lc->id) }}" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white text-xs font-black shadow-md hover:bg-rose-700 text-decoration-none">
                                📹 Join Jitsi Class
                            </a>
                        @elseif ($lc->isPublishedRecording())
                            <a href="{{ route('student.live-classes.recording', $lc->id) }}" target="_blank" class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold text-decoration-none">
                                🎬 Watch Recording
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="col-span-full p-12 text-center rounded-3xl shadow-xl space-y-3 text-white">
                    <div class="text-4xl">📚</div>
                    <h3 class="text-lg font-black text-white">No Live Classes Scheduled</h3>
                    <p class="text-xs text-slate-400">Live sessions scheduled by your course trainers will automatically appear here.</p>
                </div>
            @endforelse
        </div>

        @if ($liveClasses->hasPages())
            <div class="pt-4">
                {{ $liveClasses->links() }}
            </div>
        @endif
    </div>
</x-layouts.student>
