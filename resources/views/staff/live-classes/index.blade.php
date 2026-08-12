<x-layouts.staff>
    <!-- Top Hero Banner Card -->
    <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4 text-white">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">Live Masterclasses</h1>
            <p class="text-xs text-slate-300 mt-1">Schedule Jitsi live sessions, view real student attendance, and publish recordings.</p>
        </div>
        <a href="{{ route('staff.live-classes.create') }}" style="background-color: #D62828;" class="px-6 py-3.5 rounded-2xl text-white font-black text-sm shadow-xl hover:bg-rose-700 transition flex items-center justify-center gap-2 text-decoration-none">
            <span>➕ Schedule Jitsi Live Class</span>
        </a>
    </div>

    <div class="space-y-6 mt-6">
        <!-- Search & Multi-Filter Bar -->
        <div style="background-color: #251237; border: 1px solid rgba(241,81,83,0.25);" class="p-6 rounded-3xl shadow-xl">
            <form method="GET" action="{{ route('staff.live-classes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search class title..." style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:border-[#f15153]">
                </div>
                <div>
                    <select name="course_id" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs focus:outline-none">
                        <option value="" class="text-slate-900">All Courses</option>
                        @foreach ($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }} class="text-slate-900">{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" style="background: #1e0d2d; border: 1px solid rgba(241,81,83,0.3); color: white;" class="w-full px-4 py-2.5 rounded-xl text-xs focus:outline-none">
                        <option value="" class="text-slate-900">All Statuses</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }} class="text-slate-900">Scheduled</option>
                        <option value="starting_soon" {{ request('status') == 'starting_soon' ? 'selected' : '' }} class="text-slate-900">Starting Soon</option>
                        <option value="live" {{ request('status') == 'live' ? 'selected' : '' }} class="text-slate-900">Live Now</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }} class="text-slate-900">Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }} class="text-slate-900">Cancelled</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" style="background-color: #D62828;" class="w-full py-2.5 text-white font-black text-xs rounded-xl shadow-md">
                        Filter Classes
                    </button>
                    @if (request()->hasAny(['search', 'course_id', 'status']))
                        <a href="{{ route('staff.live-classes.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-800 text-slate-300 text-xs font-bold text-decoration-none">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Masterclass Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($liveClasses as $lc)
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
                            <div>👥 <strong>Batch:</strong> {{ $lc->batch?->name ?? 'All Batch Students' }}</div>
                            <div>📅 <strong>Start:</strong> {{ $lc->start_at->format('M d, Y @ h:i A') }}</div>
                            <div>🎯 <strong>Attendees:</strong> {{ $lc->attendees->count() }} Registered</div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
                        <a href="{{ route('staff.live-classes.show', $lc->id) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold text-decoration-none">
                            Details & Attendance ➔
                        </a>

                        @if (in_array($lc->status, ['scheduled', 'starting_soon', 'live']))
                            <a href="{{ route('staff.live-classes.join', $lc->id) }}" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white text-xs font-black shadow-md hover:bg-rose-700 text-decoration-none">
                                📹 Launch Live
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="col-span-full p-12 text-center rounded-3xl shadow-xl space-y-4 text-white">
                    <div class="text-4xl">📹</div>
                    <h3 class="text-lg font-black text-white">No Live Masterclasses Scheduled Yet</h3>
                    <p class="text-xs text-slate-300 max-w-sm mx-auto">Schedule your first Jitsi live session for your assigned course and cohort batch.</p>
                    <a href="{{ route('staff.live-classes.create') }}" style="background-color: #D62828;" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-white font-black text-xs shadow-lg text-decoration-none">
                        <span>➕ Schedule Jitsi Live Class</span>
                    </a>
                </div>
            @endforelse
        </div>

        @if ($liveClasses->hasPages())
            <div class="pt-4">
                {{ $liveClasses->links() }}
            </div>
        @endif
    </div>
</x-layouts.staff>
