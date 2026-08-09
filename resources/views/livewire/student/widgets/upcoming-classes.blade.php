<div style="background-color: #0B1F3A; border: 1px solid #1e3a5f;" class="p-6 rounded-3xl text-white shadow-xl">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-black text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>Upcoming Live Classes</span>
        </h3>
        <a href="{{ route('student.live-classes.index') }}" class="text-xs font-extrabold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($classes as $c)
            <div style="background: #112240; border: 1px solid #1e3a5f;" class="p-4 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
                <div class="flex items-center gap-3">
                    <img src="{{ $c->trainer_avatar }}" alt="{{ $c->trainer_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-700">
                    <div>
                        <div class="text-sm font-bold text-white">{{ $c->title }}</div>
                        <div class="text-xs text-slate-400">Instructor: {{ $c->trainer_name }} • {{ $c->formatted_time }} ({{ $c->duration }})</div>
                    </div>
                </div>
                <a href="{{ $c->join_url ?? route('student.live-classes.index') }}" style="background-color: #D62828;" class="px-4 py-2 rounded-xl text-white font-black text-xs shadow-md transition-all text-center text-decoration-none">
                    Join Class
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-400">No live classes scheduled for today.</div>
        @endforelse
    </div>
</div>
