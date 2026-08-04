<div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h3 class="text-lg font-extrabold text-[#0B1F3A] flex items-center gap-2">
            <span>🎥 Upcoming Live Classes</span>
        </h3>
        <a href="#" class="text-xs font-bold text-[#D62828] hover:underline">View All</a>
    </div>

    <div class="space-y-3">
        @forelse ($classes as $c)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ $c->trainer_avatar }}" alt="{{ $c->trainer_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-300">
                    <div>
                        <div class="text-sm font-bold text-[#0B1F3A]">{{ $c->title }}</div>
                        <div class="text-xs text-slate-500">Instructor: {{ $c->trainer_name }} • {{ $c->formatted_time }} ({{ $c->duration }})</div>
                    </div>
                </div>
                <a href="#" class="px-4 py-2 rounded-xl bg-[#D62828] hover:bg-[#b7102a] text-white font-bold text-xs shadow-md transition-all text-center">
                    Join Class
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-xs text-slate-500">No live classes scheduled for today.</div>
        @endforelse
    </div>
</div>
