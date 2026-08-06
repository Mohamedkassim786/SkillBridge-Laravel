<x-layouts.admin>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-white">Live Masterclasses Overview</h1>
                <p class="text-xs text-slate-300 mt-1">Platform-wide Jitsi live class audit, attendance monitoring, and recording management.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Masterclass Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($liveClasses as $lc)
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="rounded-3xl p-6 shadow-xl space-y-4 flex flex-col justify-between text-white">
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
                            <div>👨‍🏫 <strong>Trainer:</strong> {{ $lc->trainer?->name ?? 'Instructor' }}</div>
                            <div>📅 <strong>Start:</strong> {{ $lc->start_at->format('M d, Y @ h:i A') }}</div>
                            <div>👥 <strong>Attendees:</strong> {{ $lc->attendees->count() }} Registered</div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
                        <a href="{{ route('admin.live-classes.show', $lc->id) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold text-decoration-none">
                            Audit Details ➔
                        </a>
                        <a href="{{ route('admin.live-classes.attendance', $lc->id) }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold text-decoration-none">
                            Attendance 📊
                        </a>
                    </div>
                </div>
            @empty
                <div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="col-span-full p-12 text-center rounded-3xl shadow-xl space-y-3 text-white">
                    <div class="text-4xl">📹</div>
                    <h3 class="text-lg font-black text-white">No Masterclasses Found</h3>
                </div>
            @endforelse
        </div>

        @if ($liveClasses->hasPages())
            <div class="pt-4">
                {{ $liveClasses->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
